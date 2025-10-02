# ⚡ Jobs, Workers e Horizon

Este projeto usa **filas (Redis)** para processar tarefas pesadas fora do fluxo web, e **Horizon** para gerenciar/monitorar os workers. O **Scheduler** dispara tarefas recorrentes.

---

###Visão Geral

```

Browser → Nginx → APP (Laravel/PHP-FPM) → Redis ← Horizon (workers)
│
└─ Scheduler (schedule:work)

````

- **APP (web)**: atende requisições HTTP; despacha jobs para o Redis.
- **Horizon (workers)**: consome jobs do Redis e executa em background.
- **Scheduler**: roda `php artisan schedule:work` e dispara rotinas periódicas.

---

### Responsabilidades por Container

#### 1) `app`

- **Processo**: `php-fpm`
- **Responsabilidades**:
  - Atender rotas HTTP/API (controladores, views)
  - **Despachar** jobs: `dispatch(new JobX(...));`
  - Operações interativas: `migrate`, `tinker`, `test`
- **Não deve** processar filas diretamente (deixe isso para o `horizon`)

---

#### 2) `horizon` (antes: `queue`)

- **Processo**: `php artisan horizon`
- **Responsabilidades**:
  - Gerenciar **workers** (quantidade, balanceamento, memória, timeout)
  - **Executar** jobs das filas (`high`, `default`, `low`)
  - Expor dashboard em `/horizon` (metrificação e falhas)
- **Escala**:

```bash
docker compose up -d --scale horizon=3
````

---

#### 3) `scheduler`

* **Processo**: `php artisan schedule:work`

**Responsabilidades**:

* Executar tarefas agendadas definidas em `app/Console/Kernel.php`
* Normalmente 1 réplica é suficiente

---

### Configuração Essencial

`.env` (trecho):

```env
QUEUE_CONNECTION=redis
REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PORT=6379
```

`config/horizon.php` (exemplo resumido):

```php
return [
    'environments' => [
        'production' => [
            'supervisor-default' => [
                'connection'   => 'redis',
                'queue'        => ['high', 'default', 'low'],
                'balance'      => 'auto',
                'minProcesses' => 2,
                'maxProcesses' => 20,
                'tries'        => 3,
                'timeout'      => 120,
                'memory'       => 256,
                'maxTime'      => 3600,
            ],
        ],
        'local' => [
            'supervisor-default' => [
                'connection'   => 'redis',
                'queue'        => ['default'],
                'balance'      => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries'        => 3,
            ],
        ],
    ],
];
```

---

### Escrevendo e Despachando Jobs

Criar Job:

```bash
docker compose exec app php artisan make:job SyncDeputiesExpenses
```

Estrutura mínima do Job:

```php
<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

final class SyncDeputiesExpenses implements ShouldQueue
{
    use Dispatchable, Queueable;

    public int $timeout = 120;   // tempo máximo (segundos)
    public int $tries   = 3;     // tentativas de retry
    public $backoff     = 10;    // backoff entre tentativas

    public function handle(): void
    {
        // 1) Buscar dados na API
        // 2) Persistir no banco
        // 3) Emitir eventos/logs se necessário
    }
}
```

Despacho:

```php
dispatch(new \App\Jobs\SyncDeputiesExpenses());
```

Filas por prioridade (opcional):

```php
dispatch((new SyncDeputiesExpenses())->onQueue('high'));
```

---

### Agendando Tarefas (Scheduler)

`app/Console/Kernel.php`:

```php
<?php

declare(strict_types=1);

namespace App\Console;

use App\Jobs\SyncDeputiesExpenses;
use App\Jobs\SyncDeputies;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SyncDeputies())->hourly();
        $schedule->job(new SyncDeputiesExpenses())->everyFifteenMinutes();
    }
}
```

Comandos úteis:

```bash
docker compose exec app php artisan schedule:list
docker compose exec app php artisan schedule:run --verbose
```

---

### Boas Práticas

* **Idempotência**: Jobs podem rodar mais de uma vez — proteja inserts/updates
* **Timeout/memória**: defina limites no job (propriedades) e no Horizon
* **Dividir e conquistar**: prefira jobs menores e encadeados a um job gigante
* **Dead letters**: monitore o dashboard do Horizon para jobs falhos
* **Filas**: use `high/default/low` e direcione jobs críticos para `high`
* **Reinício seguro**: sempre que alterar código de jobs:

```bash
docker compose exec app php artisan queue:restart
```

---

### Diagnóstico Rápido

Ver se há workers rodando (Horizon):

```bash
docker compose logs -f horizon
```

Jobs enfileirados?

```bash
docker compose exec redis redis-cli LLEN queues:default
docker compose exec redis redis-cli LLEN queues:high
```

Listar jobs falhos (database):

```bash
docker compose exec app php artisan queue:failed
```

Limpar fila default (⚠️ cuidado!):

```bash
docker compose exec redis redis-cli DEL queues:default
```

---

### Acesso ao Horizon

* URL: [http://localhost:8080/horizon](http://localhost:8080/horizon)

Reiniciar Horizon para recarregar config:

```bash
docker compose exec app php artisan horizon:terminate
```
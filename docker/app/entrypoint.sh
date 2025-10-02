#!/bin/sh
set -e

APP_DIR="/var/www"
cd "$APP_DIR"

echo "🚀 Iniciando container (entrypoint básico)…"

# .env + app key (somente se não existir)
if [ ! -f "$APP_DIR/.env" ] && [ -f "$APP_DIR/.env.example" ]; then
  echo "🔧 Copiando .env a partir de .env.example"
  cp "$APP_DIR/.env.example" "$APP_DIR/.env" || true
  echo "🔑 Gerando chave da aplicação"
  php artisan key:generate || true
fi

# storage:link (idempotente)
if [ ! -L "$APP_DIR/public/storage" ]; then
  echo "🔗 Criando link de storage"
  php artisan storage:link || true
fi

# 👉 Em vez de forçar php-fpm aqui, execute o comando do serviço
echo "▶️ Executando comando: $@"
exec "$@"

# Arquitetura do Projeto

Este projeto é uma aplicação **Laravel 12** que consome a API pública da Câmara dos Deputados para sincronizar e exibir informações sobre deputados e suas despesas.

A arquitetura segue o padrão Laravel MVC, mas foi preparada para **execução em contêineres Docker** e **processamento assíncrono de dados**.

## Componentes Principais

- **Laravel (App)** — código principal da aplicação, serve requisições HTTP via PHP-FPM.
- **MySQL** — banco de dados relacional para persistir dados dos deputados, despesas, filas e jobs falhos.
- **Redis** — fila de jobs, cache e sessão.
- **Horizon** — gerenciador e painel de monitoramento de filas (jobs assíncronos).
- **Scheduler** — responsável por executar tarefas agendadas (`php artisan schedule:work`).
- **Nginx** — servidor web que faz proxy das requisições para o PHP-FPM.

## Fluxo Simplificado


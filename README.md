# Helply - Multi-Tenant Helpdesk SaaS Platform

<div align="center">

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.4+-purple.svg)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-17-blue.svg)

[English](#english) | [Português](#português)

</div>

---

## English

### Overview

Helply is a modern, multi-tenant helpdesk SaaS platform built with Laravel 12, Filament 4, and PostgreSQL. Each tenant gets their own isolated database for maximum security and performance.

### Features

- **Multi-tenancy** - Isolated databases per tenant
- **Ticket Management** - Complete ticket lifecycle management
- **Email Integration** - IMAP/SMTP support for email-to-ticket conversion
- **Knowledge Base** - Self-service portal with articles and categories
- **Team Management** - Organize agents into teams
- **SLA Policies** - Track response and resolution times
- **Canned Responses** - Quick replies for common questions
- **Customer Portal** - Self-service for customers
- **Reports & Analytics** - Agent performance tracking

### Tech Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| PHP | 8.4+ | Runtime |
| Laravel | 12.x | Framework |
| Filament | 4.x | Admin Panel |
| stancl/tenancy | 3.x | Multi-tenancy |
| PostgreSQL | 17 | Database |
| Redis | 7.x | Cache, Queues, Sessions |
| Livewire | 3.x | Reactive Components |
| Tailwind CSS | 4.x | Styling |
| Alpine.js | 3.x | JS Interactions |

### Installation

#### Requirements

- PHP 8.4 or higher
- Composer
- PostgreSQL 17
- Redis 7.x
- Node.js & npm

#### Steps

```bash
# Clone the repository
git clone https://github.com/yourusername/helply.git
cd helply

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your .env file with database credentials

# Run central database migrations
php artisan migrate

# Run tenant migrations (if tenants exist)
php artisan tenants:migrate

# Seed database
php artisan db:seed

# Build assets
npm run build

# Start development server
php artisan serve
```

Visit `http://localhost:8000` to access the application.

#### Docker Installation

```bash
# Start all services
docker-compose up -d

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install

# Run migrations
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tenants:migrate

# Build assets
docker-compose exec app npm run build
```

### Architecture

```
Central Domain (app.yourdomain.com)
├── Tenant Management
├── Subscription Billing
├── Platform Administration
└── Marketing Pages

Tenant Domains (*.app.yourdomain.com)
├── Helpdesk Dashboard
├── Ticket Management
├── Customer Management
├── Knowledge Base
└── Settings
```

### Configuration

The application supports subdomain-based multi-tenancy. Configure your environment:

```env
CENTRAL_DOMAIN=app.yourdomain.com
TENANT_SUBDOMAIN_SUFFIX=.app.yourdomain.com
```

Each tenant will be accessible at `{tenant-slug}.app.yourdomain.com`

### License

This project is open-sourced software licensed under the [MIT license](LICENSE).

### Author

**João Panoias**
- Email: joaopanoias@gmail.com

---

## Português

### Visão Geral

Helply é uma plataforma SaaS moderna de helpdesk multi-tenant construída com Laravel 12, Filament 4 e PostgreSQL. Cada tenant tem sua própria base de dados isolada para máxima segurança e performance.

### Funcionalidades

- **Multi-tenancy** - Bases de dados isoladas por tenant
- **Gestão de Tickets** - Gestão completa do ciclo de vida dos tickets
- **Integração Email** - Suporte IMAP/SMTP para conversão email-para-ticket
- **Base de Conhecimento** - Portal de self-service com artigos e categorias
- **Gestão de Equipas** - Organização de agentes em equipas
- **Políticas SLA** - Acompanhamento de tempos de resposta e resolução
- **Respostas Rápidas** - Respostas predefinidas para questões comuns
- **Portal Cliente** - Self-service para clientes
- **Relatórios & Analytics** - Acompanhamento de performance de agentes

### Stack Tecnológica

| Tecnologia | Versão | Propósito |
|------------|--------|-----------|
| PHP | 8.4+ | Runtime |
| Laravel | 12.x | Framework |
| Filament | 4.x | Painel Admin |
| stancl/tenancy | 3.x | Multi-tenancy |
| PostgreSQL | 17 | Base de Dados |
| Redis | 7.x | Cache, Filas, Sessões |
| Livewire | 3.x | Componentes Reativos |
| Tailwind CSS | 4.x | Estilos |
| Alpine.js | 3.x | Interações JS |

### Instalação

#### Requisitos

- PHP 8.4 ou superior
- Composer
- PostgreSQL 17
- Redis 7.x
- Node.js & npm

#### Passos

```bash
# Clonar o repositório
git clone https://github.com/seunome/helply.git
cd helply

# Instalar dependências PHP
composer install

# Instalar dependências Node
npm install

# Copiar ficheiro de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar o ficheiro .env com credenciais da base de dados

# Executar migrações da base de dados central
php artisan migrate

# Executar migrações tenant (se existirem tenants)
php artisan tenants:migrate

# Popular base de dados
php artisan db:seed

# Compilar assets
npm run build

# Iniciar servidor de desenvolvimento
php artisan serve
```

Visite `http://localhost:8000` para aceder à aplicação.

#### Instalação Docker

```bash
# Iniciar todos os serviços
docker-compose up -d

# Instalar dependências
docker-compose exec app composer install
docker-compose exec app npm install

# Executar migrações
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tenants:migrate

# Compilar assets
docker-compose exec app npm run build
```

### Arquitetura

```
Domínio Central (app.seudominio.com)
├── Gestão de Tenants
├── Faturação de Subscrições
├── Administração da Plataforma
└── Páginas de Marketing

Domínios Tenant (*.app.seudominio.com)
├── Dashboard Helpdesk
├── Gestão de Tickets
├── Gestão de Clientes
├── Base de Conhecimento
└── Definições
```

### Configuração

A aplicação suporta multi-tenancy baseado em subdomínios. Configure o ambiente:

```env
CENTRAL_DOMAIN=app.seudominio.com
TENANT_SUBDOMAIN_SUFFIX=.app.seudominio.com
```

Cada tenant estará acessível em `{tenant-slug}.app.seudominio.com`

### Licença

Este projeto é software open-source licenciado sob a [licença MIT](LICENSE).

### Autor

**João Panoias**
- Email: joaopanoias@gmail.com

---

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Support

For support, email joaopanoias@gmail.com or open an issue on GitHub.

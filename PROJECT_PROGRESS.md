# Helply - Project Progress Tracker

**Author:** João Panoias (joaopanoias@gmail.com)
**Started:** 2025-12-26
**Current Phase:** Phase 1 - Foundation

## Project Overview
Multi-tenant helpdesk SaaS platform built with Laravel 12, Filament 4, and stancl/tenancy.

## Important Notes
- **No Claude references in commits** - All commits should be attributed to João Panoias
- **Git author:** João Panoias <joaopanoias@gmail.com>
- **Public GitHub repository** with MIT License
- **Deploy to Coolify** after GitHub setup

---

## Completed Tasks

### Project Initialization
- [x] Created `composer.json` with Laravel 12, Filament 4, stancl/tenancy dependencies
- [x] Created `package.json` with Vite, Tailwind CSS 4, Alpine.js 3
- [x] Created `.env.example` with all configuration variables
- [x] Created MIT `LICENSE` file
- [x] Created project directory structure

### Files Created
1. `/composer.json` - PHP dependencies
2. `/package.json` - Node dependencies
3. `/.env.example` - Environment configuration template
4. `/LICENSE` - MIT License
5. `/PROJECT_PROGRESS.md` - This file

---

## Current Task
Creating Laravel project structure and configuration files

---

## Next Steps (Phase 1)

### Core Laravel Files Needed
- [ ] `artisan` - CLI entry point
- [ ] `bootstrap/app.php` - Application bootstrap
- [ ] `bootstrap/providers.php` - Service provider registration
- [ ] `public/index.php` - Web entry point
- [ ] `config/app.php` - Application configuration
- [ ] `config/database.php` - Database configuration
- [ ] `config/tenancy.php` - Multi-tenancy configuration
- [ ] `config/filament.php` - Filament configuration
- [ ] `routes/web.php` - Central routes
- [ ] `routes/tenant.php` - Tenant routes
- [ ] `routes/api.php` - API routes
- [ ] `routes/console.php` - Console commands

### Central Database Migrations
- [ ] `create_tenants_table`
- [ ] `create_domains_table`
- [ ] `create_plans_table`
- [ ] `create_subscriptions_table`
- [ ] `create_central_users_table`

### Tenant Database Migrations
- [ ] `create_users_table`
- [ ] `create_teams_table`
- [ ] `create_customers_table`
- [ ] `create_mailboxes_table`
- [ ] `create_tickets_table`
- [ ] `create_messages_table`
- [ ] `create_attachments_table`
- [ ] `create_tags_table`
- [ ] `create_ticket_tag_table`
- [ ] `create_canned_replies_table`
- [ ] `create_sla_policies_table`
- [ ] `create_kb_categories_table`
- [ ] `create_kb_articles_table`
- [ ] `create_settings_table`

### Models
#### Central Models
- [ ] `Tenant.php`
- [ ] `Domain.php`
- [ ] `Plan.php`
- [ ] `Subscription.php`
- [ ] `CentralUser.php`

#### Tenant Models
- [ ] `User.php`
- [ ] `Team.php`
- [ ] `Ticket.php`
- [ ] `Message.php`
- [ ] `Customer.php`
- [ ] `Mailbox.php`
- [ ] `Tag.php`
- [ ] `CannedReply.php`
- [ ] `SlaPolicy.php`
- [ ] `Workflow.php`
- [ ] `KnowledgeBase/Category.php`
- [ ] `KnowledgeBase/Article.php`

### Filament Resources
#### Central Panel
- [ ] `TenantResource.php`
- [ ] `PlanResource.php`
- [ ] `SubscriptionResource.php`
- [ ] `Dashboard.php`

#### Tenant Panel
- [ ] `TicketResource.php`
- [ ] `CustomerResource.php`
- [ ] `MailboxResource.php`
- [ ] `UserResource.php`
- [ ] `TeamResource.php`
- [ ] `TagResource.php`
- [ ] `CannedReplyResource.php`
- [ ] `KnowledgeBase/CategoryResource.php`
- [ ] `KnowledgeBase/ArticleResource.php`
- [ ] `Dashboard.php`
- [ ] `Settings.php`

### Service Providers
- [ ] `AppServiceProvider.php`
- [ ] `TenancyServiceProvider.php`
- [ ] `FilamentServiceProvider.php`

### Docker Configuration
- [ ] `docker/Dockerfile`
- [ ] `docker/nginx.conf`
- [ ] `docker/php.ini`
- [ ] `docker-compose.yml`
- [ ] `docker-compose.prod.yml`

### Documentation
- [ ] `README.md` (English)
- [ ] `docs/en/INSTALLATION.md`
- [ ] `docs/pt/README.md`
- [ ] `docs/pt/INSTALACAO.md`

### Git & GitHub Setup
- [ ] Initialize Git repository
- [ ] Create `.gitignore`
- [ ] Create `.gitattributes`
- [ ] Configure Git user (João Panoias)
- [ ] Create GitHub repository
- [ ] Push initial commit
- [ ] Configure GitHub repository settings

### Coolify Deployment
- [ ] Configure Coolify project
- [ ] Set up environment variables
- [ ] Configure wildcard SSL for *.helply.tailotek.dev
- [ ] Set up automatic deployments

---

## Technical Stack Versions
- PHP: 8.4+
- Laravel: 12.x
- Filament: 4.x
- stancl/tenancy: 3.x
- PostgreSQL: 17
- Redis: 7.x
- Livewire: 3.x
- Tailwind CSS: 4.x
- Alpine.js: 3.x

---

## Architecture Decisions

### Multi-tenancy Strategy
- **Type:** Multi-database tenancy
- **Identification:** Subdomain-based (*.helply.tailotek.dev)
- **Database naming:** `helply_tenant_{slug}`
- **Central domain:** helply.tailotek.dev

### Filament Panels
1. **Central Panel** (`/admin`) - Platform management
2. **Tenant Panel** (`/`) - Helpdesk interface

### Ticket Numbering
- Format: `HLP-XXXXXX` (e.g., HLP-000001)
- Auto-increment per tenant
- Configurable prefix

---

## Issues & Solutions

### Issue: PHP and Composer not available in environment
**Solution:** Creating Laravel project structure manually with all necessary files

---

## Commands to Run (After Installation)

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate              # Central database
php artisan tenants:migrate      # Tenant databases

# Seed initial data
php artisan db:seed

# Build assets
npm run build

# Start development
php artisan serve
npm run dev
```

---

## Git Commit Messages Format

All commits will follow this format:
- **feat:** New feature
- **fix:** Bug fix
- **docs:** Documentation changes
- **refactor:** Code refactoring
- **test:** Adding tests
- **chore:** Maintenance tasks

Example: `feat: add tenant registration flow`

---

## Last Updated
2025-12-26 - Initial project setup in progress

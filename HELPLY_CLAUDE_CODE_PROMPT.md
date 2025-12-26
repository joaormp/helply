# Helply - Multi-Tenant Helpdesk SaaS Platform

## Project Identity

- **Product Name:** Helply
- **Company:** Tailotek
- **Domain:** helply.tailotek.dev
- **Tenant URLs:** *.helply.tailotek.dev (e.g., acme.helply.tailotek.dev)
- **Repository:** Public GitHub (MIT License)
- **Languages:** Portuguese (PT-PT) primary, English (EN) secondary

---

## Technical Stack (Latest Versions)

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

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────────┐
│                      CENTRAL APP (helply.tailotek.dev)                   │
│                                                                          │
│  • Tenant registration & onboarding                                      │
│  • Subscription management (Stripe)                                      │
│  • Platform admin (Filament)                                             │
│  • Marketing pages                                                       │
├─────────────────────────────────────────────────────────────────────────┤
│                         CENTRAL DATABASE                                 │
│  tenants | domains | plans | subscriptions | invoices | central_users   │
└─────────────────────────────────────────────────────────────────────────┘
                                    │
                    ┌───────────────┼───────────────┐
                    ▼               ▼               ▼
            ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
            │  TENANT DB  │ │  TENANT DB  │ │  TENANT DB  │
            │   (acme)    │ │  (globex)   │ │    (...)    │
            ├─────────────┤ ├─────────────┤ ├─────────────┤
            │ users       │ │ users       │ │ users       │
            │ tickets     │ │ tickets     │ │ tickets     │
            │ customers   │ │ customers   │ │ customers   │
            │ mailboxes   │ │ mailboxes   │ │ mailboxes   │
            │ ...         │ │ ...         │ │ ...         │
            └─────────────┘ └─────────────┘ └─────────────┘
              acme.helply.   globex.helply.
              tailotek.dev   tailotek.dev
```

---

## Core Features to Implement

### Phase 1: Foundation
- [ ] Laravel 12 project setup
- [ ] stancl/tenancy configuration (multi-database)
- [ ] Central database migrations (tenants, domains, plans, subscriptions)
- [ ] Tenant database migrations (users, tickets, customers, mailboxes, etc.)
- [ ] Filament 4 setup with two panels: Central + Tenant
- [ ] Authentication for both contexts
- [ ] Tenant registration flow
- [ ] Subdomain routing (*.helply.tailotek.dev)

### Phase 2: Helpdesk Core
- [ ] Ticket management (CRUD, status, priority, assignment)
- [ ] Customer management
- [ ] Mailbox configuration (IMAP/SMTP)
- [ ] Email-to-ticket conversion
- [ ] Ticket replies (agents and customers)
- [ ] Internal notes
- [ ] Tags and categories
- [ ] Canned responses / templates

### Phase 3: Advanced Features
- [ ] Knowledge Base (categories + articles)
- [ ] Customer portal (public-facing)
- [ ] SLA policies and tracking
- [ ] Workflow automation (triggers + actions)
- [ ] Team management
- [ ] Agent performance reports
- [ ] Collision detection (who's viewing ticket)

### Phase 4: SaaS & Billing
- [ ] Stripe integration (subscriptions)
- [ ] Plan limits enforcement
- [ ] Usage metering
- [ ] Invoice generation
- [ ] Trial period handling

---

## Project Structure

```
helply/
├── app/
│   ├── Filament/
│   │   ├── Central/              # Central admin panel (platform)
│   │   │   ├── Resources/
│   │   │   │   ├── TenantResource.php
│   │   │   │   ├── PlanResource.php
│   │   │   │   └── SubscriptionResource.php
│   │   │   └── Pages/
│   │   │       └── Dashboard.php
│   │   └── Tenant/               # Tenant admin panel (helpdesk)
│   │       ├── Resources/
│   │       │   ├── TicketResource.php
│   │       │   ├── CustomerResource.php
│   │       │   ├── MailboxResource.php
│   │       │   ├── UserResource.php
│   │       │   ├── TeamResource.php
│   │       │   ├── TagResource.php
│   │       │   ├── CannedReplyResource.php
│   │       │   └── KnowledgeBase/
│   │       │       ├── CategoryResource.php
│   │       │       └── ArticleResource.php
│   │       ├── Pages/
│   │       │   ├── Dashboard.php
│   │       │   └── Settings.php
│   │       └── Widgets/
│   ├── Models/
│   │   ├── Central/
│   │   │   ├── Tenant.php
│   │   │   ├── Domain.php
│   │   │   ├── Plan.php
│   │   │   ├── Subscription.php
│   │   │   └── CentralUser.php
│   │   └── Tenant/
│   │       ├── User.php
│   │       ├── Team.php
│   │       ├── Ticket.php
│   │       ├── Message.php
│   │       ├── Customer.php
│   │       ├── Mailbox.php
│   │       ├── Tag.php
│   │       ├── CannedReply.php
│   │       ├── SlaPolicy.php
│   │       ├── Workflow.php
│   │       └── KnowledgeBase/
│   │           ├── Category.php
│   │           └── Article.php
│   ├── Services/
│   │   ├── TicketService.php
│   │   ├── MailParserService.php
│   │   └── SlaService.php
│   ├── Jobs/
│   ├── Events/
│   ├── Listeners/
│   └── Providers/
│       └── TenancyServiceProvider.php
├── config/
│   ├── tenancy.php
│   └── helply.php
├── database/
│   ├── migrations/
│   │   ├── central/
│   │   └── tenant/
│   └── seeders/
├── docker/
│   ├── Dockerfile
│   ├── nginx.conf
│   └── supervisord.conf
├── docs/
│   ├── pt/
│   │   ├── README.md
│   │   ├── INSTALACAO.md
│   │   └── API.md
│   └── en/
│       ├── README.md
│       ├── INSTALLATION.md
│       └── API.md
├── lang/
│   ├── pt/
│   └── en/
├── routes/
│   ├── web.php           # Central routes
│   ├── tenant.php        # Tenant routes
│   └── api.php
├── tests/
├── .env.example
├── docker-compose.yml
├── docker-compose.prod.yml
├── LICENSE               # MIT
└── README.md
```

---

## Database Schema

### Central Database

```sql
-- tenants
CREATE TABLE tenants (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    status VARCHAR(50) DEFAULT 'active',  -- active, suspended, cancelled
    data JSONB,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
);

-- domains
CREATE TABLE domains (
    id BIGSERIAL PRIMARY KEY,
    domain VARCHAR(255) UNIQUE NOT NULL,
    tenant_id VARCHAR(255) REFERENCES tenants(id) ON DELETE CASCADE,
    is_primary BOOLEAN DEFAULT false,
    is_verified BOOLEAN DEFAULT false,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- plans
CREATE TABLE plans (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    price_monthly DECIMAL(10,2) NOT NULL,
    price_yearly DECIMAL(10,2) NOT NULL,
    stripe_monthly_price_id VARCHAR(255),
    stripe_yearly_price_id VARCHAR(255),
    features JSONB NOT NULL,  -- {"agents": 5, "mailboxes": 3, "storage_gb": 10}
    limits JSONB NOT NULL,    -- {"tickets_per_month": 1000}
    is_active BOOLEAN DEFAULT true,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- subscriptions
CREATE TABLE subscriptions (
    id BIGSERIAL PRIMARY KEY,
    tenant_id VARCHAR(255) REFERENCES tenants(id) ON DELETE CASCADE,
    plan_id BIGINT REFERENCES plans(id),
    stripe_subscription_id VARCHAR(255),
    status VARCHAR(50) NOT NULL,  -- trialing, active, past_due, cancelled
    billing_cycle VARCHAR(20) NOT NULL,  -- monthly, yearly
    trial_ends_at TIMESTAMP,
    current_period_start TIMESTAMP,
    current_period_end TIMESTAMP,
    cancelled_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- central_users (Tailotek admins)
CREATE TABLE central_users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tenant Database

```sql
-- users (agents)
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'agent',  -- admin, manager, agent
    team_id BIGINT REFERENCES teams(id) ON DELETE SET NULL,
    avatar VARCHAR(255),
    signature TEXT,
    timezone VARCHAR(100) DEFAULT 'Europe/Lisbon',
    locale VARCHAR(10) DEFAULT 'pt',
    is_active BOOLEAN DEFAULT true,
    last_activity_at TIMESTAMP,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
);

-- teams
CREATE TABLE teams (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    color VARCHAR(7),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- customers
CREATE TABLE customers (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(50),
    company VARCHAR(255),
    avatar VARCHAR(255),
    notes TEXT,
    metadata JSONB,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
);

-- mailboxes
CREATE TABLE mailboxes (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    imap_host VARCHAR(255),
    imap_port INTEGER DEFAULT 993,
    imap_encryption VARCHAR(10) DEFAULT 'ssl',
    imap_username VARCHAR(255),
    imap_password TEXT,  -- encrypted
    smtp_host VARCHAR(255),
    smtp_port INTEGER DEFAULT 587,
    smtp_encryption VARCHAR(10) DEFAULT 'tls',
    smtp_username VARCHAR(255),
    smtp_password TEXT,  -- encrypted
    is_active BOOLEAN DEFAULT true,
    last_fetched_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- tickets
CREATE TABLE tickets (
    id BIGSERIAL PRIMARY KEY,
    number VARCHAR(20) UNIQUE NOT NULL,  -- HLP-000001
    subject VARCHAR(500) NOT NULL,
    status VARCHAR(50) DEFAULT 'open',  -- open, pending, resolved, closed
    priority VARCHAR(20) DEFAULT 'medium',  -- low, medium, high, urgent
    source VARCHAR(50) DEFAULT 'email',  -- email, web, api
    customer_id BIGINT REFERENCES customers(id),
    mailbox_id BIGINT REFERENCES mailboxes(id),
    assigned_to BIGINT REFERENCES users(id) ON DELETE SET NULL,
    team_id BIGINT REFERENCES teams(id) ON DELETE SET NULL,
    sla_policy_id BIGINT REFERENCES sla_policies(id),
    first_response_at TIMESTAMP,
    resolved_at TIMESTAMP,
    closed_at TIMESTAMP,
    metadata JSONB,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
);

-- messages
CREATE TABLE messages (
    id BIGSERIAL PRIMARY KEY,
    ticket_id BIGINT REFERENCES tickets(id) ON DELETE CASCADE,
    type VARCHAR(20) DEFAULT 'reply',  -- original, reply, note
    sender_type VARCHAR(20) NOT NULL,  -- customer, agent
    sender_id BIGINT,  -- customer_id or user_id
    body TEXT NOT NULL,
    body_html TEXT,
    is_internal BOOLEAN DEFAULT false,
    message_id VARCHAR(255),  -- email Message-ID
    in_reply_to VARCHAR(255),
    headers JSONB,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- attachments
CREATE TABLE attachments (
    id BIGSERIAL PRIMARY KEY,
    message_id BIGINT REFERENCES messages(id) ON DELETE CASCADE,
    filename VARCHAR(255) NOT NULL,
    path VARCHAR(500) NOT NULL,
    mime_type VARCHAR(100),
    size BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- tags
CREATE TABLE tags (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    color VARCHAR(7) DEFAULT '#6B7280',
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- ticket_tag (pivot)
CREATE TABLE ticket_tag (
    ticket_id BIGINT REFERENCES tickets(id) ON DELETE CASCADE,
    tag_id BIGINT REFERENCES tags(id) ON DELETE CASCADE,
    PRIMARY KEY (ticket_id, tag_id)
);

-- canned_replies
CREATE TABLE canned_replies (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    subject VARCHAR(500),
    body TEXT NOT NULL,
    is_shared BOOLEAN DEFAULT true,
    user_id BIGINT REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- sla_policies
CREATE TABLE sla_policies (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    first_response_time INTEGER,  -- minutes
    resolution_time INTEGER,      -- minutes
    priority VARCHAR(20),
    conditions JSONB,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- kb_categories
CREATE TABLE kb_categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    parent_id BIGINT REFERENCES kb_categories(id) ON DELETE SET NULL,
    sort_order INTEGER DEFAULT 0,
    is_published BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- kb_articles
CREATE TABLE kb_articles (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(500) NOT NULL,
    slug VARCHAR(500) UNIQUE NOT NULL,
    excerpt TEXT,
    body TEXT NOT NULL,
    category_id BIGINT REFERENCES kb_categories(id) ON DELETE SET NULL,
    author_id BIGINT REFERENCES users(id),
    views_count INTEGER DEFAULT 0,
    is_published BOOLEAN DEFAULT false,
    published_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- settings
CREATE TABLE settings (
    id BIGSERIAL PRIMARY KEY,
    group VARCHAR(100) NOT NULL,
    key VARCHAR(100) NOT NULL,
    value TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(group, key)
);
```

---

## Configuration Requirements

### .env.example

```env
APP_NAME=Helply
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=https://helply.tailotek.dev

# Central Domain
CENTRAL_DOMAIN=helply.tailotek.dev

# Tenant Domains
TENANT_SUBDOMAIN_SUFFIX=.helply.tailotek.dev

# Database (Central)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=helply_central
DB_USERNAME=helply
DB_PASSWORD=

# Tenant Database Prefix
TENANT_DB_PREFIX=helply_tenant_

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Queue
QUEUE_CONNECTION=redis

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120

# Cache
CACHE_DRIVER=redis

# Mail
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@helply.tailotek.dev"
MAIL_FROM_NAME="${APP_NAME}"

# Stripe
STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=

# Filesystem
FILESYSTEM_DISK=local
```

---

## Docker Configuration

### docker-compose.yml

```yaml
services:
  app:
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: helply-app
    restart: unless-stopped
    volumes:
      - .:/var/www/html
      - ./docker/php.ini:/usr/local/etc/php/conf.d/custom.ini
    networks:
      - helply
    depends_on:
      - postgres
      - redis

  nginx:
    image: nginx:alpine
    container_name: helply-nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - .:/var/www/html
      - ./docker/nginx.conf:/etc/nginx/conf.d/default.conf
    networks:
      - helply
    depends_on:
      - app

  postgres:
    image: postgres:17-alpine
    container_name: helply-postgres
    restart: unless-stopped
    environment:
      POSTGRES_USER: helply
      POSTGRES_PASSWORD: ${DB_PASSWORD}
      POSTGRES_DB: helply_central
    volumes:
      - postgres_data:/var/lib/postgresql/data
    ports:
      - "5432:5432"
    networks:
      - helply

  redis:
    image: redis:7-alpine
    container_name: helply-redis
    restart: unless-stopped
    command: redis-server --appendonly yes
    volumes:
      - redis_data:/data
    ports:
      - "6379:6379"
    networks:
      - helply

  queue:
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: helply-queue
    restart: unless-stopped
    command: php artisan queue:work --sleep=3 --tries=3 --max-time=3600
    volumes:
      - .:/var/www/html
    networks:
      - helply
    depends_on:
      - app
      - redis

  scheduler:
    build:
      context: .
      dockerfile: docker/Dockerfile
    container_name: helply-scheduler
    restart: unless-stopped
    command: php artisan schedule:work
    volumes:
      - .:/var/www/html
    networks:
      - helply
    depends_on:
      - app

networks:
  helply:
    driver: bridge

volumes:
  postgres_data:
  redis_data:
```

---

## Key Implementation Notes

### Multi-tenancy Setup (stancl/tenancy)

1. **Identification by subdomain:** tenant slug extracted from subdomain
2. **Database per tenant:** each tenant gets `helply_tenant_{slug}` database
3. **Central domains:** `helply.tailotek.dev`, `www.helply.tailotek.dev`
4. **Tenant domains:** `*.helply.tailotek.dev`

### Filament Panels

1. **Central Panel** (`/admin`): Platform management for Tailotek
   - Tenant CRUD
   - Plan management
   - Subscription overview
   - Platform settings

2. **Tenant Panel** (`/`): Helpdesk for each tenant
   - Ticket management
   - Customer management
   - Knowledge Base
   - Settings
   - Reports

### Ticket Number Format

- Pattern: `HLP-XXXXXX` (e.g., HLP-000001)
- Auto-increment per tenant
- Configurable prefix per tenant

---

## Security Considerations

- [ ] All credentials via environment variables
- [ ] No secrets in repository
- [ ] IMAP/SMTP passwords encrypted at rest
- [ ] Tenant isolation enforced at database level
- [ ] Rate limiting on API endpoints
- [ ] CSRF protection on all forms
- [ ] XSS prevention on ticket content
- [ ] File upload validation and sanitization

---

## Internationalization (i18n)

- Default locale: `pt` (Portuguese)
- Fallback locale: `en` (English)
- All strings translatable
- Date/time respects user timezone
- Currency: EUR (default)

---

## Deployment (Coolify)

- Automatic deploy on merge to `main`
- Wildcard SSL for `*.helply.tailotek.dev`
- Health check endpoint: `/health`
- Zero-downtime deployments

---

## Getting Started Instructions

After project setup, the following should work:

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate          # Central database
php artisan tenants:migrate  # Tenant databases

# Seed initial data
php artisan db:seed

# Build assets
npm run build

# Start development
php artisan serve
npm run dev
```

---

## Definition of Done (Phase 1)

- [ ] Fresh Laravel 12 project created
- [ ] stancl/tenancy installed and configured
- [ ] Filament 4 installed with Central + Tenant panels
- [ ] Central database migrations working
- [ ] Tenant database migrations working
- [ ] Tenant registration creates subdomain + database
- [ ] Login works for both Central and Tenant contexts
- [ ] Basic Ticket CRUD in Tenant panel
- [ ] Docker Compose working locally
- [ ] README with setup instructions (PT + EN)
- [ ] MIT License file
- [ ] .env.example with all variables documented

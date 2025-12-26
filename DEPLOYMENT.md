# Helply - Deployment Guide

This guide covers deploying Helply to various environments, including Coolify.

## Coolify Deployment

### Prerequisites

- Coolify server set up and running
- Domain name configured with wildcard DNS (*.app.yourdomain.com)
- GitHub repository access

### Step 1: Create New Project in Coolify

1. Log in to your Coolify dashboard
2. Click "New Project"
3. Select "Public Repository"
4. Enter repository URL: `https://github.com/joaormp/helply`
5. Select branch: `master`

### Step 2: Configure Build Settings

**Build Pack:** Docker (or PHP if using PHP buildpack)

**Environment Variables:**
```env
APP_NAME=Helply
APP_ENV=production
APP_DEBUG=false
APP_URL=https://app.yourdomain.com
APP_TIMEZONE=Europe/Lisbon
APP_LOCALE=pt
APP_FALLBACK_LOCALE=en

# Generate this key after deployment: php artisan key:generate --show
APP_KEY=base64:YOUR_GENERATED_KEY_HERE

# Central Domain
CENTRAL_DOMAIN=app.yourdomain.com

# Tenant Domains - MUST include leading dot
TENANT_SUBDOMAIN_SUFFIX=.app.yourdomain.com

# Database (Central)
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=helply_central
DB_USERNAME=helply
DB_PASSWORD=YOUR_SECURE_PASSWORD

# Tenant Database Prefix
TENANT_DB_PREFIX=helply_tenant_

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=.app.yourdomain.com

# Cache
CACHE_STORE=redis

# Queue
QUEUE_CONNECTION=redis

# Redis
REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# Stripe (optional - for billing)
STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=

# Logging
LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error
```

### Step 3: Configure Services

Helply requires these services:

**PostgreSQL 17**
- Service name: `postgres`
- Database: `helply_central`
- Username: `helply`
- Password: (set in environment)

**Redis 7**
- Service name: `redis`
- Port: 6379

### Step 4: Configure Domains

1. **Central Domain:** `app.yourdomain.com`
2. **Wildcard Domain:** `*.app.yourdomain.com`

**DNS Configuration:**
```
Type: A
Name: app
Value: YOUR_SERVER_IP

Type: A
Name: *
Value: YOUR_SERVER_IP
```

### Step 5: SSL Configuration

Coolify will automatically provision SSL certificates using Let's Encrypt for:
- Main domain: `app.yourdomain.com`
- Wildcard: `*.app.yourdomain.com`

**Important:** Ensure your DNS is properly configured before deploying to avoid rate limits.

### Step 6: Build Commands

**Install Dependencies:**
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

**Run Migrations:**
```bash
php artisan migrate --force
```

**Create Admin User (Central Panel):**
```bash
php artisan make:filament-user --panel=central
```

### Step 7: Post-Deployment Commands

After successful deployment, run these commands:

```bash
# Clear all caches
php artisan optimize:clear

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link
```

### Step 8: Queue Worker

Configure a queue worker in Coolify:

**Command:**
```bash
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

**Process Manager:** Supervisor (recommended)

### Step 9: Scheduler

Configure the Laravel scheduler:

**Command:**
```bash
php artisan schedule:work
```

Or add to crontab:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Production Checklist

- [ ] Set `APP_DEBUG=false`
- [ ] Generate secure `APP_KEY`
- [ ] Configure strong database passwords
- [ ] Set up wildcard SSL certificate
- [ ] Configure email (SMTP)
- [ ] Set up queue worker
- [ ] Set up scheduler
- [ ] Configure backups (database + storage)
- [ ] Set up monitoring
- [ ] Test tenant creation
- [ ] Test ticket creation
- [ ] Verify email delivery

## Creating Your First Tenant

1. Access Central Panel: `https://app.yourdomain.com/admin`
2. Log in with admin credentials
3. Go to "Tenants" → "Create Tenant"
4. Fill in:
   - **Name:** Company Name
   - **Slug:** company-slug (becomes: company-slug.app.yourdomain.com)
   - **Email:** admin@company.com
   - **Status:** Active
5. Click "Create"
6. The tenant database will be created automatically
7. Access tenant at: `https://company-slug.app.yourdomain.com`

## Troubleshooting

### Wildcard SSL Not Working

Ensure DNS propagation is complete:
```bash
dig app.yourdomain.com
dig test.app.yourdomain.com
```

Both should return your server IP.

### Tenant Database Not Created

Check logs:
```bash
php artisan tinker
App\Models\Central\Tenant::all()
```

Manually create database:
```bash
php artisan tenants:migrate
```

### Queue Not Processing

Check queue worker:
```bash
php artisan queue:work --once
```

Check failed jobs:
```bash
php artisan queue:failed
```

## Support

For deployment issues, check:
- [Coolify Documentation](https://coolify.io/docs)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)
- [GitHub Issues](https://github.com/joaormp/helply/issues)

## Security Notes

- Never commit `.env` file to repository
- Use strong passwords for database
- Enable firewall rules
- Regular security updates
- Monitor error logs
- Set up automated backups
- Use HTTPS everywhere
- Implement rate limiting

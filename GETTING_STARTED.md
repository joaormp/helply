# Getting Started with Helply

This guide will help you get up and running with Helply quickly.

## 🚀 Quick Setup

### 1. Database Setup

First, run the migrations for the central database:

```bash
php artisan migrate --path=database/migrations/central
```

### 2. Seed Demo Data

Seed the central database with demo tenants and plans:

```bash
php artisan db:seed --class=CentralDatabaseSeeder
```

This will create:
- **Admin user**: admin@helply.test / password
- **3 Subscription Plans**: Starter, Professional, Enterprise
- **5 Demo Tenants**: acme, techstart, creative-studio, startup-hub, digital-agency

### 3. Create Tenant Databases

Run migrations for all tenant databases:

```bash
php artisan tenants:migrate
```

### 4. Seed Tenant Data

Populate each tenant with demo data:

```bash
php artisan tenants:seed --class=TenantDatabaseSeeder
```

This creates for each tenant:
- 2 Teams (Support Team, Technical Team)
- 4 Users/Agents (including admin)
- 5 Customers with company details
- 10-20 Tickets with various statuses
- Multiple Messages per ticket
- 5 Tags for categorization
- 5 Canned Reply templates
- 4 SLA Policies

## 🔑 Access Credentials

### Central Panel (Admin)
- **URL**: http://localhost:8000/admin/login
- **Email**: admin@helply.test
- **Password**: password

### Tenant Panels (For each tenant)
- **URL**: http://localhost:8000/t/{tenant}/login
- **Example**: http://localhost:8000/t/acme/login

**Available tenants**:
- acme
- techstart
- creative-studio
- startup-hub
- digital-agency

**Admin credentials for each tenant**:
- **Email**: admin@{tenant-slug}.test
- **Password**: password
- **Example**: admin@acme.test / password

**Agent credentials**:
- maria@{tenant-slug}.test / password
- joao@{tenant-slug}.test / password
- carlos@{tenant-slug}.test / password

## 📊 Navigation Structure

The tenant panel is organized into logical groups:

### Support
- **Tickets**: Manage customer support tickets
- **Customers**: Customer database and profiles
- **Tags**: Organize tickets with tags

### Channels
- **Mailboxes**: Configure email accounts for ticket creation

### Knowledge Base
- **Articles**: Help center articles
- **Categories**: Organize articles in categories
- **Canned Replies**: Pre-written response templates

### Team Management
- **Users**: Manage agents and their roles
- **Teams**: Organize agents into teams

### Settings
- **Settings**: General, Tickets, Email, KB, SLA configuration
- **SLA Policies**: Service level agreement policies

## 🎯 Key Features to Try

### 1. Ticket Management
1. Go to Support → Tickets
2. Create a new ticket
3. Assign it to an agent or team
4. Add tags for organization
5. Use canned replies for quick responses

### 2. Knowledge Base
1. Go to Knowledge Base → Categories
2. Create a category (e.g., "Getting Started")
3. Go to Knowledge Base → Articles
4. Create articles within categories
5. Toggle public/private visibility

### 3. Team Collaboration
1. Go to Team Management → Teams
2. Create or edit teams
3. Go to Team Management → Users
4. Create new agents and assign them to teams
5. Set roles (Admin, Manager, Agent)

### 4. Canned Replies
1. Go to Knowledge Base → Canned Replies
2. Create templates with placeholders:
   - {{customer_name}}
   - {{ticket_number}}
   - {{agent_name}}
3. Mark as shared or keep private

### 5. SLA Policies
1. Go to Settings → SLA Policies
2. Create policies with response/resolution times
3. Assign to priority levels
4. Track SLA compliance

### 6. Settings Configuration
1. Go to Settings → Settings
2. Configure:
   - Company information
   - Ticket defaults
   - Email notifications
   - Knowledge Base settings
   - SLA and business hours

## 🔧 Development Commands

### Run Development Server
```bash
php artisan serve
# Access at http://localhost:8000
```

### Build Frontend Assets
```bash
npm run build
# or for development with watch
npm run dev
```

### Code Formatting
```bash
vendor/bin/pint
```

### Clear Caches
```bash
php artisan optimize:clear
```

### Run Tests
```bash
php artisan test
```

## 📝 Tips & Best Practices

1. **Ticket Numbers**: Auto-generated with format HLP-XXXXXX
2. **Priorities**: Low, Normal, High, Urgent
3. **Statuses**: Open, Pending, On Hold, Solved, Closed
4. **Tags**: Use for categorization and filtering
5. **SLA Tracking**: Enable in Settings and assign policies
6. **Canned Replies**: Use placeholders for personalization
7. **Teams**: Organize by department or specialty
8. **Knowledge Base**: Keep articles updated and well-organized

## 🆘 Troubleshooting

### Cannot Login to Tenant Panel
- Ensure the tenant database exists: `php artisan tenants:list`
- Re-run tenant migrations: `php artisan tenants:migrate`
- Re-seed tenant data: `php artisan tenants:seed --class=TenantDatabaseSeeder`

### Missing Assets (CSS/JS)
- Run: `php artisan filament:assets`
- Build assets: `npm run build`
- Clear cache: `php artisan optimize:clear`

### Database Errors
- Check .env database credentials
- Ensure PostgreSQL is running
- Run migrations: `php artisan migrate --path=database/migrations/central`

## 📚 Next Steps

1. Explore the different panels and features
2. Customize settings for your needs
3. Create your own tickets and test workflows
4. Configure mailboxes for email integration
5. Set up SLA policies for your team
6. Build out your knowledge base

---

**Need Help?** Check the main [README.md](README.md) for more detailed information.

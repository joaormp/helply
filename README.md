# Helply - Modern Helpdesk Platform

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-4.3-orange.svg)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-purple.svg)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-17-blue.svg)](https://postgresql.org)

A modern, multi-tenant helpdesk platform built with Laravel 12, Filament 4.3, and React 19. Helply provides a complete customer support solution with ticket management, knowledge base, team collaboration, and SLA tracking.

## ✨ Features

### 🎫 Ticket Management
- **Smart Ticketing System** with auto-generated ticket numbers (HLP-XXXXXX)
- **Multi-channel Support** - Email, web portal, and API
- **Priority & Status Workflow** - Low, Normal, High, Urgent with customizable statuses
- **Team Assignment** - Route tickets to specific teams or agents
- **Tag System** - Organize and categorize tickets efficiently
- **Advanced Filters** - Search by status, priority, agent, team, tags, and source

### 📧 Email Integration
- **IMAP/SMTP Configuration** - Connect your email accounts
- **Email-to-Ticket Conversion** - Automatic ticket creation from emails (Coming soon)
- **Email Templates** - Customizable email notifications
- **Email Signatures** - Per-agent and global signatures

### 📚 Knowledge Base
- **Nested Categories** - Organize articles in hierarchical structure
- **Rich Text Editor** - Create beautiful, formatted articles
- **Public/Private Access** - Control article visibility
- **Search Functionality** - Help customers find answers quickly
- **Article Feedback** - Track article helpfulness

### 👥 Team Collaboration
- **Team Management** - Organize agents into teams
- **User Management** - Full agent/user CRUD with role assignments
- **Role-Based Access** - Admin, Manager, Agent, Customer roles
- **Team Performance Metrics** - Track team productivity
- **Workload Distribution** - Balance tickets across teams
- **Canned Replies** - Pre-written response templates with placeholders
- **SLA Policies** - Service level agreements with response time tracking

### 📊 Analytics & Reporting
- **Real-time Dashboards** - Central and Tenant panel dashboards
- **Performance Metrics** - Track response times, satisfaction rates
- **Team Analytics** - Monitor team performance and productivity
- **Custom Reports** - Generate insights from your data

### 🏢 Multi-Tenancy
- **Database-per-Tenant** - Complete data isolation
- **Subdomain Routing** - Automatic tenant detection
- **Custom Domains** - Support for branded domains
- **Subscription Management** - Flexible pricing plans

### 🌍 Internationalization
- **Bilingual Interface** - Full support for Portuguese and English
- **Language Switcher** - Easy language toggle in UI
- **LocalStorage Persistence** - Remember user language preference

## 🚀 Quick Start

### Prerequisites

- PHP 8.4 or higher
- PostgreSQL 17 or higher
- Composer
- Node.js 20.x and npm
- Laravel Herd (recommended) or Laravel Valet/Homestead

### Installation

1. **Clone the repository**
\`\`\`bash
git clone https://github.com/joaormp/helply.git
cd helply
\`\`\`

2. **Install PHP dependencies**
\`\`\`bash
composer install
\`\`\`

3. **Install Node dependencies**
\`\`\`bash
npm install
\`\`\`

4. **Configure environment**
\`\`\`bash
cp .env.example .env
php artisan key:generate
\`\`\`

5. **Update .env with your database credentials**
\`\`\`env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=helply_central
DB_USERNAME=your_username
DB_PASSWORD=your_password
\`\`\`

6. **Run migrations**
\`\`\`bash
# Central database migrations
php artisan migrate --path=database/migrations/central
\`\`\`

7. **Build frontend assets**
\`\`\`bash
npm run build
\`\`\`

8. **Start the development server**
\`\`\`bash
php artisan serve
\`\`\`

9. **Create admin user**
\`\`\`bash
php artisan make:filament-user --panel=central
\`\`\`

Visit \`http://localhost:8000\` to see the landing page, and \`http://localhost:8000/admin/login\` for the admin panel.

## 🧪 Testing

\`\`\`bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage
\`\`\`

## 📝 Code Style

This project uses [Laravel Pint](https://laravel.com/docs/pint) for code formatting:

\`\`\`bash
vendor/bin/pint
\`\`\`

## 🗺️ Roadmap

- [x] Multi-tenant architecture
- [x] Ticket management system
- [x] Knowledge base
- [x] Team management
- [x] User management
- [x] Canned replies
- [x] SLA policies and tracking
- [x] Dashboards and widgets
- [x] Database seeders with demo data
- [ ] Email-to-ticket conversion
- [ ] Real-time notifications
- [ ] Customer portal
- [ ] REST API

## 📊 Status

- **Development**: Active
- **Progress**: ~95% complete
- **Version**: 0.9.5 (Beta)
- **Target Launch**: Q1 2025

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**João Panoias**
- Email: [joaopanoias@gmail.com](mailto:joaopanoias@gmail.com)
- GitHub: [@joaormp](https://github.com/joaormp)

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP framework for web artisans
- [Filament](https://filamentphp.com) - Elegant admin panels for Laravel
- [React](https://react.dev) - A JavaScript library for building user interfaces
- [Tailwind CSS](https://tailwindcss.com) - A utility-first CSS framework

---

<p align="center">Made with ❤️ by João Panoias</p>
<p align="center">
  <sub>🤖 Built with assistance from <a href="https://claude.com/claude-code">Claude Code</a></sub>
</p>

# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

### Changed

### Deprecated

### Removed

### Fixed

### Security

## [0.4.0] - 2025-12-26 (dev branch)

### Added
- GitHub Actions CI/CD workflows (automated testing + code quality)
- Pest PHP testing framework with PHPUnit configuration
- TenantManagementTest suite with 4 tests
- Comprehensive database seeders:
  - PlanSeeder with 4 subscription tiers
  - CentralUserSeeder for platform admins
  - TenantSeeder with demo tenants (ACME, Globex)
  - TenantDatabaseSeeder with sample data (users, customers, tickets, tags)
- CustomerResource for Filament tenant panel
- Customer avatar support with UI Avatars fallback
- Automated testing on push and pull requests

### Changed
- Enhanced development workflow with automated testing
- Improved data seeding for faster local setup

## [0.3.0] - 2025-12-26

### Added
- Path-based routing support for easier local development
- InitializeTenancyByPath middleware for /t/{tenant} URLs
- .env.local.example for DBngin local development setup
- .env.production.example for Coolify deployment reference
- DEVELOPMENT.md comprehensive development guide
- QUICKSTART.md for quick setup instructions
- Support for dual routing modes (path-based local, subdomain production)

### Changed
- Updated TenantPanelProvider to support /t/{tenant} paths
- Updated tenant routes to use path-based routing
- Improved local development workflow documentation

## [0.2.0] - 2025-12-26

### Added
- Filament 4 Central Panel Provider for platform administration
- Filament 4 Tenant Panel Provider for helpdesk interface
- TenantResource for Central panel (CRUD operations for tenants)
- TicketResource for Tenant panel (full ticket management)
- Vite configuration for frontend asset building
- Tailwind CSS 4 and PostCSS configuration
- Alpine.js 3 integration
- Frontend resource files (app.css, app.js, bootstrap.js)

### Changed
- Updated README to use generic domain placeholders
- Updated .env.example with configurable domain settings
- Updated LICENSE to remove company references

### Removed
- Removed all company-specific references from public files
- Removed internal documentation from repository
- Removed development files from git tracking

## [0.1.0] - 2025-12-26

### Added
- Initial project structure
- Basic Laravel 12 setup
- Multi-database tenancy architecture
- Docker development environment

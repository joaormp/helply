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

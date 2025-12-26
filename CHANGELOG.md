# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial project setup with Laravel 12
- Multi-tenancy configuration with stancl/tenancy
- Central database migrations (tenants, domains, plans, subscriptions, central_users)
- Tenant database migrations (users, teams, customers, mailboxes, tickets, messages, etc.)
- Central models (Tenant, Domain, Plan, Subscription, CentralUser)
- Tenant models (User, Team, Customer, Ticket, Message, Mailbox, Tag, etc.)
- Docker Compose setup for local development
- Subdomain routing for tenant access
- Environment configuration template
- MIT License
- README documentation (English and Portuguese)

### Changed

### Deprecated

### Removed

### Fixed

### Security

## [0.1.0] - 2025-12-26

### Added
- Initial project structure
- Basic Laravel 12 setup
- Multi-database tenancy architecture
- Docker development environment

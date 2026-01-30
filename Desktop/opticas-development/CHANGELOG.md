# Changelog

All notable changes to Opticas-Development are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [Unreleased]

### Planned
- Multi-currency support
- Advanced reporting with data visualization
- Mobile app for sales staff
- Integration with additional payment gateways
- AI-powered inventory forecasting

---

## [1.0.0] - 2026-01-29

### Added

#### Core Features
- **Point of Sale (POS) System**
  - Multi-product cart support
  - Real-time inventory integration
  - Multiple payment methods (cash, card, transfer, SPEI)
  - Automatic discount and promotion application
  - Credit and aside (partial payment) support
  - PDF ticket generation (58mm thermal format)

- **Patient Management**
  - Complete patient registration
  - Personal information tracking (Person entity)
  - Multiple phone numbers
  - Tax information (RFC for Mexico)
  - Customer card system
  - Company/contract management

- **Inventory System**
  - Multi-store inventory tracking
  - FIFO stock management
  - Automatic stock decrement on sales
  - Inventory rollback on cancellations
  - Stock transfer between stores
  - Purchase order management
  - Low stock alerts

- **Consultation System**
  - Medical consultation records
  - General medical background
  - Visual evaluation tracking
  - Prescription generation
  - Doctor management
  - Consultation history

- **Financial Module**
  - Expense tracking with categories
  - Income recording
  - Sales commission calculation
  - Credit management
  - Bank account management
  - Invoice generation

- **Promotions & Discounts**
  - Promo code system
  - Percentage and fixed amount discounts
  - Buy X get Y promotions
  - Manual discount authorization (PIN-based)
  - Promotion item configuration

- **Reporting**
  - Sales summary reports
  - Inventory reports
  - Commission reports
  - Multi-store consolidated reports

#### Architecture
- **Service Layer Pattern**
  - SaleService
  - SaleItemService
  - InventoryService
  - PatientService
  - ConsultationService
  - PrescriptionService
  - PaymentService
  - CreditService
  - DiscountService

- **Domain-Driven Design**
  - Entity layer with type casting
  - Business rules encapsulation
  - Aggregate roots

- **Repository Pattern**
  - Abstract data access
  - Model-based implementations

#### Security
- **Authentication & Authorization**
  - CodeIgniter Shield integration
  - Role-based access control
  - JWT token support
  - Session management

- **Security Features**
  - CSRF protection
  - XSS prevention
  - SQL injection prevention (query binding)
  - Password hashing (Argon2id/BCRYPT)
  - Secure file uploads

#### API
- **REST API Endpoints**
  - Complete CRUD operations for all entities
  - Authentication endpoints
  - Sales and payment processing
  - Inventory management
  - Patient and consultation management
  - Reporting endpoints

- **API Features**
  - Bearer token authentication
  - Request validation
  - Error handling
  - Rate limiting support
  - Pagination

#### Database
- **MySQL 8.0 Support**
  - UTF8MB4 charset
  - Optimistic locking support
  - Soft deletes
  - Timestamps (created_at, updated_at)
  - Foreign key constraints

- **Migration System**
  - Version-controlled migrations
  - Seeding support
  - Rollback capabilities

#### DevOps
- **Docker Support**
  - Development environment (docker-compose.yml)
  - Production-ready Dockerfile
  - FrankenPHP/Caddy server
  - MySQL container
  - PHPMyAdmin for database management

- **CI/CD Ready**
  - PHPUnit testing framework
  - Code quality checks
  - Docker image building

#### Documentation
- **Comprehensive Documentation**
  - README.md with badges and quick start
  - Technical documentation (DOCUMENTACION_TECNICA.md)
  - API documentation (docs/api/README.md)
  - Database schema (docs/database/README.md)
  - Deployment guide (docs/deployment/README.md)
  - Contributing guide (CONTRIBUTING.md)
  - Changelog (CHANGELOG.md)

- **Developer Tools**
  - .env.example configuration template
  - Database schema diagrams
  - API examples
  - Coding standards

### Technical Details

#### Technologies
- **PHP 8.1+** with modern features
- **CodeIgniter 4.x** framework
- **MySQL 8.0+** database
- **Docker 24.x+** containerization
- **FrankenPHP** web server (Caddy-based)
- **CodeIgniter Shield** authentication
- **Spipu Html2Pdf** PDF generation
- **Ramsey UUID** UUID generation
- **PHPUnit** testing framework

#### Performance
- Optimized database queries
- Redis caching support
- OPcache enabled
- Gzip compression
- CDN-ready static assets

#### Monitoring
- Application logging (Monolog)
- Health check endpoints
- Performance metrics
- Error tracking

### Known Limitations
- Single currency support (MXN)
- No multi-tenant support
- Limited real-time features
- No mobile app yet
- No advanced analytics

### Migration Notes

#### From Previous Version
- N/A (Initial release)

#### Database Migration
- Run `php spark migrate` to create all tables
- Run `php spark db:seed` to load initial data

#### Configuration
- Copy `.env.example` to `.env`
- Set `CI_ENVIRONMENT = production` for production
- Generate encryption key with `php spark key:generate`
- Configure database credentials
- Set `app.baseURL` to your domain

### Breaking Changes

#### From Legacy System
- Database schema completely redesigned
- API endpoints follow RESTful conventions
- Authentication changed to CodeIgniter Shield
- Inventory management uses FIFO instead of LIFO
- PDF generation library changed (FPDF → Spipu Html2Pdf)

---

## [0.9.0] - 2025-12-15

### Added
- Beta release
- Core POS functionality
- Basic inventory tracking
- Patient registration

### Changed
- Moved from PHP 7.4 to 8.1
- Updated CodeIgniter from 3 to 4

### Fixed
- Database connection issues
- Session management bugs

---

## [0.1.0] - 2025-06-01

### Added
- Initial project structure
- Basic framework setup
- Development environment

---

## Version Summary

| Version | Release Date | Status | Notes |
|---------|--------------|--------|-------|
| 1.0.0 | 2026-01-29 | ✅ Stable | First production release |
| 0.9.0 | 2025-12-15 | 🟢 Beta | Feature complete beta |
| 0.1.0 | 2025-06-01 | 🔵 Alpha | Initial development |

---

## Contributors

### Version 1.0.0
- Core Development Team
- QA Team
- Documentation Team

---

## Support

For version-specific issues, please include the version number in bug reports.

**Documentation:** [GitHub](https://github.com/tu-usuario/opticas-development)  
**Support:** soporte@opticas-development.local

---

**Note:** This changelog follows the [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) format.

---

## Upcoming Roadmap

### Version 1.1.0 (Q2 2026)
- Multi-currency support
- Advanced reporting with charts
- Mobile responsive improvements

### Version 1.2.0 (Q3 2026)
- Mobile app (iOS/Android)
- Push notifications
- Advanced analytics

### Version 2.0.0 (Q4 2026)
- Multi-tenant architecture
- Advanced inventory forecasting
- AI-powered recommendations

---

**Last Updated:** January 29, 2026

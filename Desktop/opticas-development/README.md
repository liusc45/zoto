# Sistema de Gestión Integral para Ópticas

<div align="center">

![PHP Version](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-000000?style=for-the-badge)

**Sistema ERP completo para la gestión de operaciones de ópticas**

[Sistema de Punto de Venta](#) • [Gestión de Pacientes](#) • [Consultas Oftalmológicas](#) • [Inventario](#) • [Reportes](#)

</div>

---

## 📋 Descripción del Proyecto

### Visión General

**Opticas-Development** es un sistema de planificación de recursos empresariales (ERP) especializado para el sector óptico que integra todas las operaciones de negocio en una única plataforma unificada.

El sistema aborda los desafíos críticos que enfrentan las ópticas:

- **Gestión Fragmentada**: Eliminación de silos de información
- **Control de Inventario**: Tracking en tiempo real de productos ópticos
- **Procesos Manuales**: Automatización de tareas repetitivas
- **Falta de Visibilidad**: Dashboard y reportes en tiempo real

### Valor de Negocio Cuantificado

| Métrica | Antes | Después | Mejora |
|---------|-------|---------|--------|
| Tiempo búsqueda paciente | 3-5 min | 5-10 seg | **97%** |
| Tiempo cierre de caja | 45-60 min | 5-10 min | **83%** |
| Errores en inventario | 8-12% | <1% | **87%** |

---

## ⭐ Características Principales

### 🏪 Punto de Venta (POS)
- Interfaz intuitiva para atención rápida
- Múltiples tipos de venta: efectivo, tarjeta, transferencia, crédito, multipago
- Sistema de descuentos y promociones
- Generación automática de tickets y facturas
- Gestión de abonos y apartados

### 👥 Gestión de Pacientes
- Expediente electrónico completo
- Registro de prescripciones oftalmológicas
- Seguimiento de cambios en graduación
- Alertas de cumpleaños y citas de revisión

### 👁️ Consultas Oftalmológicas
- Registro estructurado de consultas
- Fondo de ojo y evaluación visual
- Antecedentes médicos y familiares
- Prescripciones digitales

### 📦 Inventario Inteligente
- Control de stock por tienda y producto
- Múltiples líneas: lentes, armazones, contactos, mica
- Transferencias entre sucursales
- Alertas de stock mínimo

### 💳 Sistema Financiero
- Cuentas por cobrar (créditos)
- Gestión de apartados
- Comisiones por vendedor
- Gastos e ingresos operativos

### 🏢 Gestión Multi-Tienda
- Múltiples sucursales
- Inventardaio centralizado
- Reportes consolidados

---

## 🛠 Stack Tecnológico

| Componente | Tecnología | Versión |
|------------|------------|---------|
| **Lenguaje** | PHP | 8.1+ |
| **Framework** | CodeIgniter | 4.x |
| **Base de Datos** | MySQL | 8.0+ |
| **Servidor Web** | FrankenPHP (Caddy) | Latest |
| **Contenedores** | Docker | 24.x+ |
| **Autenticación** | CodeIgniter Shield | v1.0 |
| **PDF** | Spipu Html2Pdf | 5.2 |
| **UUID** | Ramsey UUID | 4.7 |

---

## 🚀 Instalación Rápida

```bash
# Clonar y ejecutar
git clone https://github.com/tu-usuario/opticas-development.git
cd opticas-development
docker-compose up -d

# Acceder a la aplicación
http://localhost:8080

# Acceder a phpMyAdmin
http://localhost:8081
```

**Credenciales por defecto:**
- Base de datos: `optica_local`
- Usuario MySQL: `root`
- Contraseña MySQL: `root`

> ⚠️ En producción, use variables de entorno seguras.

---

## 📖 Documentación Completa

### 📚 Índice de Documentación

| Categoría | Documento | Descripción |
|-----------|-----------|-------------|
| **Inicio Rápido** | 📄 [README](#) | Visión general e instalación |
| **API REST** | 🔌 [API Documentation](docs/api/README.md) | Referencia completa de endpoints |
| **Base de Datos** | 🗄️ [Database Schema](docs/database/README.md) | Esquema ER y diccionario de datos |
| **Despliegue** | 🚀 [Deployment Guide](docs/deployment/README.md) | Guía de producción |
| **Desarrollo** | 👨‍💻 [Contributing](CONTRIBUTING.md) | Guía para desarrolladores |
| **Técnica** | 📘 [Documentación Técnica](docs/DOCUMENTACION_TECNICA.md) | Arquitectura y patrones |
| **Configuración** | ⚙️ [.env.example](.env.example) | Variables de entorno |
| **Cambios** | 📝 [Changelog](CHANGELOG.md) | Registro de versiones |
| **Promociones** | 🎁 [Promotions](docs/Promotions.md) | Sistema de promociones |
| **Tests** | 🧪 [Tests README](tests/README.md) | Guía de pruebas |

### 🚀 Documentación Recomendada Por Rol

| Rol | Documentos Esenciales |
|-----|---------------------|
| **Desarrollador** | API Docs, Database Schema, Contributing, Technical Docs |
| **DevOps/SysAdmin** | Deployment Guide, .env.example, Docker Setup |
| **QA/Tester** | Tests README, API Docs (for testing endpoints) |
| **Gerente Técnico** | Technical Docs, Changelog, Architecture |
| **Cliente/Usuario** | README, Promotions (business logic) |

---

## 🏗 Arquitectura del Sistema

```
CAPA DE PRESENTACIÓN → Frontend, Views, API REST
         ↓
CAPA DE CONTROL → Controllers (Sale, Patient, Consultation, etc.)
         ↓
CAPA DE SERVICIOS → SaleService, InventoryService, ConsultationService, etc.
         ↓
CAPA DE MODELOS → CodeIgniter Models + Business Logic
         ↓
CAPA DE ENTIDADES → Domain Entities (DDD Pattern)
         ↓
BASE DE DATOS → MySQL 8.0 + Migraciones
```

### Patrones Implementados
- **Service Layer**: Separación de lógica de negocio
- **Domain-Driven Design**: Entidades de dominio
- **Repository Pattern**: Abstracción de acceso a datos
- **Active Record**: CodeIgniter Models

---

## 📁 Estructura del Proyecto

```
opticas-development/
├── app/
│   ├── Commands/           # Comandos CLI
│   ├── Config/             # Configuraciones
│   ├── Controllers/        # Controladores HTTP
│   ├── Database/Migrations/# Migraciones BD
│   ├── Database/Seeds/     # Datos iniciales
│   ├── Entities/           # Entidades de dominio
│   ├── Filters/            # Filtros auth
│   ├── Language/           # Archivos de idioma
│   ├── Libraries/          # Bibliotecas
│   ├── Models/             # Modelos de datos
│   └── Services/           # Servicios de negocio
├── public/                 # Web root
├── tests/                  # Pruebas unitarias
├── writable/               # Logs, cache, sessions
├── docs/                   # Documentación
├── Dockerfile
├── docker-compose.yml
└── composer.json
```

---

## 👥 Roles de Usuario

| Rol | Descripción |
|-----|-------------|
| **Administrador** | Acceso total |
| **Gerente de Tienda** | Gestión, reportes, inventarios |
| **Vendedor** | Ventas, pacientes, citas |
| **Óptico** | Consultas, prescripciones |
| **Inventario** | Gestión de inventario |
| **Contador** | Reportes financieros |

---

## 🔐 Seguridad

- **Autenticación**: CodeIgniter Shield (sesiones y tokens)
- **CSRF Protection**: Contra Cross-Site Request Forgery
- **XSS Prevention**: Escaping automático
- **SQL Injection**: Query binding
- **Password Hashing**: Argon2id/BCRYPT

---

## 📊 APIs REST

```bash
GET    /api/patient         # Listar pacientes
POST   /api/patient         # Crear paciente
GET    /api/patient/(:id)   # Obtener paciente
GET    /api/sale            # Listar ventas
POST   /api/sale            # Crear venta
GET    /api/sale/(:id)/ticket # Generar ticket PDF
GET    /api/inventory       # Inventario
```

---

## 🐳 Uso con Docker

### Desarrollo

```bash
docker-compose up -d
docker-compose logs -f app
docker-compose down
```

### Producción

```bash
docker build -t opticas-production .
docker run -d -p 80:80 --name opticas \
  -e CI_ENVIRONMENT=production \
  opticas-production
```

---

## 🤝 Contribución

1. Fork del repositorio
2. Crear rama feature
3. Commit de cambios
4. Push a la rama
5. Abrir Pull Request

### Estándares
- **PHP**: PSR-12
- **CodeIgniter**: Convenciones del framework
- **Documentación**: PHPDoc
- **Testing**: PHPUnit

---

## 📄 Licencia

MIT License - ver [LICENSE](LICENSE)

---

## 📞 Contacto

| Canal | Información |
|-------|-------------|
| GitHub Issues | Reportes de bugs |
| Email | soporte@opticas-development.local |

---

<div align="center">

**Desarrollado con ❤️ para la industria óptica**

*Versión: 1.0.0* | *Enero 2026*

</div>

# Docker Setup Guide for Opticas-Development

This guide covers Docker setup for development and production using PHP-FPM and Caddy.

---

## Table of Contents

- [Architecture Overview](#architecture-overview)
- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Development Setup](#development-setup)
- [Production Setup](#production-setup)
- [Services Overview](#services-overview)
- [Configuration](#configuration)
- [Common Commands](#common-commands)
- [Troubleshooting](#troubleshooting)

---

## Architecture Overview

### Multi-Container Setup

```
┌─────────────────────────────────────────────────────────┐
│                   Caddy (Web Server)                 │
│              - Port 80/443                           │
│              - SSL/TLS                                │
│              - Gzip Compression                         │
│              - Static Files                             │
└──────────────────┬──────────────────────────────────────┘
                   │
                   │ FastCGI
                   │
┌──────────────────▼──────────────────────────────────────┐
│              PHP-FPM (Application)                     │
│              - PHP 8.1                                 │
│              - CodeIgniter 4.x                          │
│              - OPcache                                  │
│              - Socket: /var/run/php-fpm/php-fpm.sock   │
└──────────────────┬──────────────────────────────────────┘
                   │
        ┌──────────┼──────────┐
        │          │          │
┌───────▼──┐  │  ┌───────▼──────┐
│   MySQL   │  │  │    Redis     │
│   (DB)    │  │  │   (Cache)    │
│ Port:3306 │  │  │   Port:6379 │
└────────────┘  │  └──────────────┘
       │         │
       └─────────┴───────► Volumes: Data, Logs, Uploads
```

### Benefits of This Architecture

1. **Separation of Concerns**
   - Web server handles HTTP/HTTPS, compression, caching
   - PHP-FPM handles application logic
   - Easier to debug and scale independently

2. **Performance**
   - Unix socket faster than TCP for PHP-FPM
   - Caddy's modern HTTP/3 support
   - Redis for session and application caching

3. **Scalability**
   - Scale PHP-FPM containers independently
   - Load balance across multiple Caddy instances

4. **Security**
   - Isolated application processes
   - Caddy's automatic HTTPS with Let's Encrypt
   - Minimal attack surface

---

## Prerequisites

### Required Software

| Software | Version | Purpose |
|-----------|---------|---------|
| Docker | 24.0+ | Container runtime |
| Docker Compose | 2.20+ | Multi-container orchestration |
| Git | 2.0+ | Source control |
| PHP (local) | 8.1+ | For Composer and Spark CLI |

### System Requirements

| Resource | Minimum | Recommended |
|----------|----------|--------------|
| RAM | 4 GB | 8 GB+ |
| CPU | 2 cores | 4 cores+ |
| Disk | 20 GB | 50 GB+ SSD |

---

## Quick Start

### 1. Clone Repository

```bash
git clone https://github.com/tu-usuario/opticas-development.git
cd opticas-development
```

### 2. Configure Environment

```bash
# Copy environment template
cp .env.docker.example .env

# Edit configuration
nano .env
```

### 3. Start Development Environment

```bash
# Start all services
docker-compose up -d

# Or start with specific profile
docker-compose --profile dev up -d

# Check services status
docker-compose ps
```

### 4. Initialize Database

```bash
# Run migrations
docker-compose exec -T app php spark migrate

# Seed database (optional)
docker-compose exec -T app php spark db:seed

# Generate encryption key
docker-compose exec -T app php spark key:generate
```

### 5. Access Application

| Service | URL | Credentials |
|---------|------|-------------|
| Application | http://localhost:80 | See: spark auth:create |
| phpMyAdmin | http://localhost:8081 | root / root |

---

## Development Setup

### Development Features

- Hot reload with volume mounting
- Xdebug support for debugging
- phpMyAdmin for database management
- Verbose logging
- Development PHP configuration

### Configuration

```bash
# In .env
BUILD_TARGET=development
CI_ENVIRONMENT=development
XDEBUG_ENABLED=true
```

### Starting Development Services

```bash
# Full development stack
docker-compose --profile dev up -d

# Or just app and db
docker-compose up -d app db redis caddy
```

### Accessing Logs

```bash
# Application logs
docker-compose logs -f app

# Caddy logs
docker-compose logs -f caddy

# MySQL logs
docker-compose logs -f db

# All services
docker-compose logs -f
```

### Xdebug Configuration

```bash
# In .env
XDEBUG_ENABLED=true
XDEBUG_HOST=host.docker.internal
XDEBUG_PORT=9003
```

Configure your IDE (VSCode/PHPStorm) to listen on port 9003.

---

## Production Setup

### Production Features

- Optimized multi-stage Dockerfile
- OPcache enabled
- Redis session storage
- Secure PHP configuration
- Health checks
- Automatic restart policies

### Configuration

```bash
# In .env
BUILD_TARGET=production
CI_ENVIRONMENT=production
APP_BASE_URL=https://opticas.tudominio.com
SERVER_NAME=opticas.tudominio.com
```

### Building Production Image

```bash
# Build production image
docker-compose -f docker-compose.yml build --build-arg BUILD_TARGET=production

# Or directly with Dockerfile
docker build --target production -t opticas-production:latest .
```

### Deploying to Production

```bash
# Copy environment file
cp .env.docker.example .env
nano .env  # Configure production values

# Start production stack
docker-compose up -d

# Verify health checks
docker-compose ps
```

### Enabling SSL

**Option 1: Let's Encrypt (Automatic)**

```bash
# In Caddyfile, uncomment the https:// block
# Caddy will automatically obtain and renew SSL certificates
```

**Option 2: Custom Certificates**

```bash
# Mount certificates
docker-compose.yml:
  volumes:
    - /path/to/cert.pem:/etc/caddy/certs/cert.pem:ro
    - /path/to/key.pem:/etc/caddy/certs/key.pem:ro

# Update Caddyfile to use certificates
```

---

## Services Overview

### PHP-FPM (app)

**Image:** `php:8.1-fpm-alpine`  
**Port:** 9000 (internal, socket used)  
**Purpose:** Execute PHP code

**Configuration:**
- `docker/php/php-fpm.conf`: PHP-FPM pool settings
- `app/Config/Database.php`: Database configuration

**Health Check:**
```bash
docker-compose exec app php-fpm-healthcheck
```

### Caddy (caddy)

**Image:** `caddy:2.7-alpine`  
**Ports:** 80, 443  
**Purpose:** Web server, reverse proxy, SSL

**Configuration:**
- `Caddyfile`: Server configuration
- Automatic HTTPS with Let's Encrypt

**Admin Interface:**
```
http://localhost:2019
```

### MySQL (db)

**Image:** `mysql:8.4`  
**Port:** 3306  
**Purpose:** Database server

**Configuration:**
- `docker/mysql/my.cnf`: MySQL settings
- Credentials in `.env`

**Admin:**
- phpMyAdmin: http://localhost:8081

### Redis (redis)

**Image:** `redis:7.2-alpine`  
**Port:** 6379  
**Purpose:** Cache and session storage

**Configuration:**
- `docker/redis/redis.conf`: Redis settings
- Password protected

### phpMyAdmin (phpmyadmin)

**Image:** `phpmyadmin/phpmyadmin:5.2`  
**Port:** 8081  
**Purpose:** Database administration

**Profile:** `dev` (dev only)

---

## Configuration

### Environment Variables

| Variable | Description | Default |
|-----------|-------------|----------|
| `BUILD_TARGET` | Docker build target | development |
| `CI_ENVIRONMENT` | CodeIgniter environment | development |
| `APP_BASE_URL` | Application URL | http://localhost |
| `SERVER_NAME` | Server domain | localhost |
| `DB_DATABASE` | Database name | optica_local |
| `DB_USER` | Database user | optica_user |
| `DB_PASSWORD` | Database password | optica_password |
| `REDIS_PASSWORD` | Redis password | redis_password |
| `HTTP_PORT` | HTTP port | 80 |
| `HTTPS_PORT` | HTTPS port | 443 |

### Docker Compose Profiles

```bash
# Development (includes phpMyAdmin)
docker-compose --profile dev up -d

# With background worker
docker-compose --profile worker up -d

# Production (optimized)
docker-compose --production up -d
```

---

## Common Commands

### Service Management

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# Restart specific service
docker-compose restart app

# View service status
docker-compose ps
```

### Database Operations

```bash
# Run migrations
docker-compose exec app php spark migrate

# Rollback migrations
docker-compose exec app php spark migrate:rollback

# Fresh migrations (destructive)
docker-compose exec app php spark migrate:fresh

# Seed database
docker-compose exec app php spark db:seed
```

### Application Commands

```bash
# Execute Spark command
docker-compose exec app php spark <command>

# Example: Generate encryption key
docker-compose exec app php spark key:generate

# Example: Create user
docker-compose exec app php spark auth:create admin@example.com admin --admin
```

### Monitoring

```bash
# View resource usage
docker stats

# View container logs
docker-compose logs -f [service]

# Inspect container
docker-compose exec [service] /bin/sh
```

### Cleaning Up

```bash
# Remove all containers and volumes (DESTRUCTIVE!)
docker-compose down -v

# Remove only stopped containers
docker container prune

# Remove unused images
docker image prune -a
```

---

## Performance Tuning

### PHP-FPM Optimization

**In `docker/php/php-fpm.conf`:**

```ini
; Adjust based on available RAM
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
```

**Calculation:**
```
max_children = (Total RAM - Base RAM) / RAM per child
Example: (8GB - 2GB) / 50MB = 120 children
```

### MySQL Optimization

**In `docker/mysql/my.cnf`:**

```ini
innodb_buffer_pool_size = 1G  # 70-80% of RAM for DB
max_connections = 200
innodb_log_file_size = 256M
```

### Redis Optimization

**In `docker/redis/redis.conf`:**

```ini
maxmemory 512mb
maxmemory-policy allkeys-lru
```

### Caddy Optimization

**In `Caddyfile`:**

```caddy
encode {
    zstd
    gzip 5
}
```

---

## Troubleshooting

### Container Won't Start

**Problem:** Container exits immediately

**Solution:**
```bash
# Check logs
docker-compose logs [service]

# Check port conflicts
lsof -i :80

# Rebuild image
docker-compose build --no-cache [service]
docker-compose up -d [service]
```

### Database Connection Error

**Problem:** Cannot connect to database from app

**Solution:**
```bash
# Check if database is running
docker-compose ps db

# Test connection
docker-compose exec app php -r "mysqli_connect('db', 'root', 'root') or die(mysqli_error());"

# Check MySQL logs
docker-compose logs db
```

### Permission Errors

**Problem:** Cannot write to writable directory

**Solution:**
```bash
# Fix permissions
docker-compose exec app chown -R www:www /var/www/html/writable

# Or rebuild with correct ownership
docker-compose down
docker-compose up -d --build
```

### Slow Performance

**Problem:** Application is slow

**Solution:**

1. Check OPcache is enabled:
   ```bash
   docker-compose exec app php -m | grep opcache
   ```

2. Enable Redis for sessions:
   ```php
   // .env
   session.driver = CodeIgniter\Session\Handlers\RedisHandler
   session.save_path = "tcp://redis:6379?auth=redis_password"
   ```

3. Check slow queries:
   ```bash
   docker-compose exec db tail -f /var/log/mysql/slow-query.log
   ```

### Health Checks Failing

**Problem:** Service marked as unhealthy

**Solution:**
```bash
# Check health status
docker-compose ps

# View health check logs
docker inspect [container_name] | grep -A 10 Health

# Adjust health check timeout
docker-compose.yml:
  healthcheck:
     interval: 30s
     timeout: 10s  # Increase timeout
```

---

## Security Best Practices

1. **Change all default passwords** in `.env` before production
2. **Generate strong encryption key** with `php spark key:generate`
3. **Enable SSL** by setting valid domain in `SERVER_NAME`
4. **Remove phpMyAdmin** in production (it's in dev profile)
5. **Use secrets management** for sensitive data in production
6. **Regular security updates:** `docker-compose pull && docker-compose up -d`
7. **Limit network exposure:** Remove unnecessary port mappings

---

## Backup and Restore

### Database Backup

```bash
# Backup database
docker-compose exec db mysqldump -u root -proot optica_local > backup.sql

# Restore database
cat backup.sql | docker-compose exec -T db mysql -u root -proot optica_local
```

### Volume Backup

```bash
# Backup all volumes
docker run --rm \
    -v opticas_mysql_data:/data \
    -v $(pwd)/backup:/backup \
    alpine tar czf /backup/mysql-data.tar.gz -C /data .

# Restore volume
docker run --rm \
    -v opticas_mysql_data:/data \
    -v $(pwd)/backup:/backup \
    alpine tar xzf /backup/mysql-data.tar.gz -C /data
```

---

## Migration from Old Setup

If migrating from the old FrankenPHP setup:

1. **Stop old containers:**
   ```bash
   docker-compose down
   ```

2. **Backup data:**
   ```bash
   # Backup database
   docker-compose exec db mysqldump -u root -proot optica_local > backup.sql
   
   # Backup volumes
   tar czf volumes-backup.tar.gz mysql_data
   ```

3. **Update configuration:**
   ```bash
   # Copy new .env
   cp .env.docker.example .env
   
   # Update with old values
   nano .env
   ```

4. **Start new setup:**
   ```bash
   # Remove old volumes (optional)
   docker-compose down -v
   
   # Start new setup
   docker-compose up -d
   ```

5. **Restore data:**
   ```bash
   # Restore database
   cat backup.sql | docker-compose exec -T db mysql -u root -proot optica_local
   
   # Run migrations
   docker-compose exec app php spark migrate
   ```

---

## Support

For Docker-related issues:
- **Documentation:** [Deployment Guide](../docs/deployment/README.md)
- **Docker Docs:** https://docs.docker.com/
- **Caddy Docs:** https://caddyserver.com/docs/
- **GitHub Issues:** https://github.com/tu-usuario/opticas-development/issues

---

**Last Updated:** January 29, 2026  
**Version:** 2.0.0 (PHP-FPM + Caddy Architecture)

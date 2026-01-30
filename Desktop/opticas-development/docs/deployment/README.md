# Deployment Guide

Complete guide for deploying Opticas-Development to production.

---

## Table of Contents

- [Prerequisites](#prerequisites)
- [Server Requirements](#server-requirements)
- [Environment Configuration](#environment-configuration)
- [Docker Deployment](#docker-deployment)
- [Traditional Server Deployment](#traditional-server-deployment)
- [SSL/HTTPS Setup](#sslhttps-setup)
- [Monitoring and Logging](#monitoring-and-logging)
- [Backup Strategy](#backup-strategy)
- [Security Hardening](#security-hardening)
- [Performance Tuning](#performance-tuning)
- [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before deploying, ensure you have:

- **Git** (for code management)
- **Docker & Docker Compose** (for containerized deployment)
- **MySQL 8.0+** (database server)
- **PHP 8.1+** (for traditional deployment)
- **Domain name** (recommended for production)
- **SSL certificate** (required for secure connections)
- **Access to:** Server SSH, database, DNS provider

---

## Server Requirements

### Minimum Hardware

| Resource | Development | Production |
|----------|-------------|------------|
| CPU | 2 vCPU | 4 vCPU+ |
| RAM | 2 GB | 8 GB+ |
| Storage | 20 GB SSD | 50 GB+ SSD |
| Network | 100 Mbps | 1 Gbps |

### Software Requirements

**For Docker Deployment:**
- Docker 24.0+
- Docker Compose 2.20+

**For Traditional Deployment:**
- PHP 8.1+ with extensions:
  - intl
  - mbstring
  - json
  - mysqlnd
  - gd
  - curl
  - zip
  - xml
- MySQL 8.0+
- Nginx or Apache 2.4+
- Composer 2.0+

---

## Environment Configuration

### 1. Clone Repository

```bash
git clone https://github.com/tu-usuario/opticas-development.git
cd opticas-development
```

### 2. Configure Environment Variables

```bash
# Copy example environment file
cp .env.example .env

# Edit configuration
nano .env
```

**Critical Production Settings:**

```env
# Set production environment
CI_ENVIRONMENT = production

# Database credentials (CHANGE THESE!)
database.default.hostname = localhost
database.default.username = optica_prod_user
database.default.password = STRONG_PASSWORD_HERE
database.default.database = optica_production
database.default.port = 3306

# Generate encryption key
encryption.key = GENERATE_WITH_PHP_SPARK_KEY_GENERATE

# App URL (CHANGE TO YOUR DOMAIN)
app.baseURL = 'https://opticas.tudominio.com/'

# Disable debug features
toolbar.enabled = false
logger.threshold = 4  # Only log errors and above
```

### 3. Generate Encryption Key

```bash
# In development:
php spark key:generate

# Or generate manually:
php -r "echo bin2hex(random_bytes(32));"
```

### 4. Configure Database

```bash
# Create database and user
mysql -u root -p
```

```sql
CREATE DATABASE optica_production CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER 'optica_prod_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_HERE';
GRANT ALL PRIVILEGES ON optica_production.* TO 'optica_prod_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## Docker Deployment

### Option 1: Docker Compose (Recommended)

#### 1. Prepare Docker Environment

```bash
# Build production image
docker build -t opticas-production:latest .

# Or use the pre-built image
docker pull tu-usuario/opticas-production:latest
```

#### 2. Configure docker-compose.prod.yml

Create `docker-compose.prod.yml`:

```yaml
version: '3.8'

services:
  app:
    image: opticas-production:latest
    container_name: opticas-app
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    environment:
      - CI_ENVIRONMENT=production
      - APP_BASEURL=https://opticas.tudominio.com
    volumes:
      - ./uploads:/var/www/html/public/uploads
      - ./logs:/var/www/html/writable/logs
    networks:
      - opticas-network
    depends_on:
      - db

  db:
    image: mysql:8.0
    container_name: opticas-db
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: optica_production
      MYSQL_USER: optica_prod_user
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - mysql-data:/var/lib/mysql
      - ./mysql-init:/docker-entrypoint-initdb.d
    networks:
      - opticas-network
    ports:
      - "3306:3306"

  redis:
    image: redis:7-alpine
    container_name: opticas-redis
    restart: unless-stopped
    networks:
      - opticas-network
    volumes:
      - redis-data:/data

networks:
  opticas-network:
    driver: bridge

volumes:
  mysql-data:
  redis-data:
```

#### 3. Deploy

```bash
# Start containers
docker-compose -f docker-compose.prod.yml up -d

# Check status
docker-compose -f docker-compose.prod.yml ps

# View logs
docker-compose -f docker-compose.prod.yml logs -f app
```

#### 4. Run Migrations

```bash
# Execute migrations in container
docker-compose -f docker-compose.prod.yml exec app php spark migrate

# Seed database (if needed)
docker-compose -f docker-compose.prod.yml exec app php spark db:seed
```

### Option 2: Kubernetes Deployment

#### 1. Create Kubernetes Manifests

**deployment.yaml:**

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: opticas-app
  labels:
    app: opticas
spec:
  replicas: 3
  selector:
    matchLabels:
      app: opticas
  template:
    metadata:
      labels:
        app: opticas
    spec:
      containers:
      - name: opticas
        image: opticas-production:latest
        ports:
        - containerPort: 80
        env:
        - name: CI_ENVIRONMENT
          value: "production"
        - name: APP_BASEURL
          value: "https://opticas.tudominio.com"
        resources:
          requests:
            memory: "512Mi"
            cpu: "500m"
          limits:
            memory: "1Gi"
            cpu: "1000m"
---
apiVersion: v1
kind: Service
metadata:
  name: opticas-service
spec:
  selector:
    app: opticas
  ports:
  - protocol: TCP
    port: 80
    targetPort: 80
  type: LoadBalancer
```

#### 2. Deploy to Cluster

```bash
kubectl apply -f deployment.yaml

# Check deployment status
kubectl get deployments

# Check pods
kubectl get pods

# Get logs
kubectl logs -f deployment/opticas-app
```

---

## Traditional Server Deployment

### 1. Install Dependencies

**Ubuntu/Debian:**

```bash
# Update package list
sudo apt update

# Install Nginx, PHP 8.1, MySQL
sudo apt install nginx php8.1-fpm php8.1-mysql php8.1-curl php8.1-gd php8.1-mbstring php8.1-xml php8.1-zip mysql-server

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. Configure PHP

Edit `/etc/php/8.1/fpm/php.ini`:

```ini
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 10M
post_max_size = 10M
date.timezone = America/Mexico_City
```

Restart PHP-FPM:

```bash
sudo systemctl restart php8.1-fpm
```

### 3. Configure Nginx

Create `/etc/nginx/sites-available/opticas`:

```nginx
server {
    listen 80;
    server_name opticas.tudominio.com;

    root /var/www/opticas/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Logs
    access_log /var/log/nginx/opticas-access.log;
    error_log /var/log/nginx/opticas-error.log;

    # CodeIgniter configuration
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }

    location ~ /(writable|tests|vendor) {
        deny all;
    }
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/opticas /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 4. Deploy Application

```bash
# Copy files to server
rsync -avz --exclude='.git' --exclude='vendor' --exclude='node_modules' \
    /local/path/opticas-development/ user@server:/var/www/opticas/

# Install dependencies
cd /var/www/opticas
composer install --no-dev --optimize-autoloader

# Set permissions
sudo chown -R www-data:www-data /var/www/opticas
sudo chmod -R 755 /var/www/opticas
sudo chmod -R 777 writable/{cache,logs,session,uploads}

# Run migrations
php spark migrate
```

---

## SSL/HTTPS Setup

### Option 1: Let's Encrypt (Free)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d opticas.tudominio.com

# Auto-renewal is configured automatically
sudo certbot renew --dry-run
```

### Option 2: Commercial Certificate

```nginx
server {
    listen 443 ssl http2;
    server_name opticas.tudominio.com;

    ssl_certificate /path/to/your/certificate.crt;
    ssl_certificate_key /path/to/your/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Rest of configuration...
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name opticas.tudominio.com;
    return 301 https://$server_name$request_uri;
}
```

---

## Monitoring and Logging

### Application Logs

```bash
# View real-time logs
tail -f /var/www/opticas/writable/logs/log-$(date +%Y-%m-%d).log

# View error logs
tail -f /var/www/opticas/writable/logs/error.log
```

### Docker Logs

```bash
# View container logs
docker-compose -f docker-compose.prod.yml logs -f app

# View last 100 lines
docker-compose -f docker-compose.prod.yml logs --tail=100 app
```

### Nginx Logs

```bash
# Access logs
tail -f /var/log/nginx/opticas-access.log

# Error logs
tail -f /var/log/nginx/opticas-error.log
```

### MySQL Slow Query Log

Edit `/etc/mysql/mysql.conf.d/mysqld.cnf`:

```ini
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow-query.log
long_query_time = 2
```

---

## Backup Strategy

### Automated Database Backups

Create `/usr/local/bin/backup-opticas.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/backups/opticas"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="optica_production"
DB_USER="optica_prod_user"
DB_PASS="STRONG_PASSWORD"
RETENTION_DAYS=30

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/backup_$DATE.sql.gz

# Upload to S3 (optional)
aws s3 cp $BACKUP_DIR/backup_$DATE.sql.gz s3://backups-bucket/opticas/

# Remove old backups
find $BACKUP_DIR -name "backup_*.sql.gz" -mtime +$RETENTION_DAYS -delete
```

Make executable and add to crontab:

```bash
chmod +x /usr/local/bin/backup-opticas.sh

# Add to crontab (daily at 2 AM)
crontab -e
```

```
0 2 * * * /usr/local/bin/backup-opticas.sh
```

### File Backups

```bash
# Backup uploads directory
tar -czf /backups/opticas/uploads_$(date +%Y%m%d).tar.gz /var/www/opticas/public/uploads

# Backup application configuration
tar -czf /backups/opticas/config_$(date +%Y%m%d).tar.gz /var/www/opticas/.env
```

---

## Security Hardening

### 1. Update System Regularly

```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Configure Firewall

```bash
# Install UFW
sudo apt install ufw

# Allow SSH
sudo ufw allow OpenSSH

# Allow HTTP/HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable

# Check status
sudo ufw status
```

### 3. Secure MySQL

```bash
sudo mysql_secure_installation
```

### 4. File Permissions

```bash
# Restrict writable directory access
chmod 750 writable
chmod 640 .env

# Remove unnecessary files
rm -f composer.json package.json
```

### 5. Disable Debug Mode

Ensure `.env` has:

```env
CI_ENVIRONMENT = production
toolbar.enabled = false
```

### 6. Rate Limiting (Nginx)

Add to Nginx config:

```nginx
# Rate limiting zone
limit_req_zone $binary_remote_addr zone=api:10m rate=10r/s;

# Apply to API location
location /api {
    limit_req zone=api burst=20 nodelay;
    # ... rest of config
}
```

---

## Performance Tuning

### 1. Enable OPcache

Edit `/etc/php/8.1/fpm/conf.d/10-opcache.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.enable_cli=0
```

### 2. Enable Redis Cache

Install Redis:

```bash
sudo apt install redis-server
sudo systemctl enable redis-server
```

Configure cache in `.env`:

```env
cache.handler = Redis
cache.redis.host = 127.0.0.1
cache.redis.port = 6379
cache.redis.password = 
cache.redis.database = 0
```

### 3. Optimize MySQL

Edit `/etc/mysql/mysql.conf.d/mysqld.cnf`:

```ini
[mysqld]
innodb_buffer_pool_size = 2G
innodb_log_file_size = 512M
max_connections = 200
query_cache_size = 64M
```

Restart MySQL:

```bash
sudo systemctl restart mysql
```

### 4. Enable Gzip Compression

Add to Nginx config:

```nginx
gzip on;
gzip_vary on;
gzip_min_length 1024;
gzip_types text/plain text/css text/xml text/javascript application/x-javascript application/xml+rss application/json;
```

### 5. Enable Browser Caching

```nginx
location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
    expires 30d;
    add_header Cache-Control "public, immutable";
}
```

---

## Troubleshooting

### Application Not Loading

1. Check Nginx error logs:
   ```bash
   tail -f /var/log/nginx/opticas-error.log
   ```

2. Check PHP-FPM status:
   ```bash
   sudo systemctl status php8.1-fpm
   ```

3. Verify file permissions:
   ```bash
   ls -la /var/www/opticas/writable
   ```

### Database Connection Errors

1. Test database connection:
   ```bash
   mysql -u optica_prod_user -p optica_production
   ```

2. Check MySQL status:
   ```bash
   sudo systemctl status mysql
   ```

3. Verify `.env` credentials

### Slow Page Load

1. Check PHP error logs:
   ```bash
   tail -f /var/www/opticas/writable/logs/error.log
   ```

2. Enable query logging in `.env`:
   ```env
   database.default.DBDebug = true
   ```

3. Check MySQL slow query log:
   ```bash
   tail -f /var/log/mysql/slow-query.log
   ```

### High Memory Usage

1. Check memory usage:
   ```bash
   free -h
   top
   ```

2. Adjust PHP memory limit:
   ```ini
   memory_limit = 128M
   ```

3. Adjust MySQL buffer pool size:
   ```ini
   innodb_buffer_pool_size = 1G
   ```

### Docker Container Issues

1. View container logs:
   ```bash
   docker-compose logs -f app
   ```

2. Restart containers:
   ```bash
   docker-compose restart app
   ```

3. Rebuild containers:
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```

---

## Update Process

### Update Application

```bash
# Pull latest code
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php spark migrate

# Clear cache
php spark cache:clear

# Restart services
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
```

### Update Docker Deployment

```bash
# Pull latest image
docker pull tu-usuario/opticas-production:latest

# Recreate containers
docker-compose -f docker-compose.prod.yml up -d --force-recreate

# Run migrations
docker-compose -f docker-compose.prod.yml exec app php spark migrate
```

---

## Rollback Plan

### Database Rollback

```bash
# Rollback last migration
php spark migrate:rollback

# Rollback multiple steps
php spark migrate:rollback -n 5
```

### Application Rollback

```bash
# Restore from Git
git log
git checkout <commit-hash>

# Restore database backup
gunzip < backup_20260129.sql.gz | mysql -u root -p optica_production
```

---

## Support and Maintenance

For deployment assistance, contact:

- **Technical Support:** soporte@opticas-development.local
- **Documentation:** /docs/DOCUMENTACION_TECNICA.md
- **API Documentation:** /docs/api/README.md

---

## Checklists

### Pre-Deployment Checklist

- [ ] Environment variables configured
- [ ] Database created and accessible
- [ ] Encryption key generated
- [ ] SSL certificate installed
- [ ] Firewall configured
- [ ] Backup strategy in place
- [ ] Monitoring configured
- [ ] File permissions set correctly
- [ ] Dependencies installed (composer install --no-dev)
- [ ] Migrations tested in staging

### Post-Deployment Checklist

- [ ] Application loads correctly
- [ ] Database migrations completed
- [ ] SSL certificate valid
- [ ] Logs are being written
- [ ] Backup script running
- [ ] Health checks passing
- [ ] Performance acceptable
- [ ] Security scan passed

---

**Last Updated:** January 29, 2026  
**Version:** 1.0.0

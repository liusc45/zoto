# FAQ & Troubleshooting Guide

Frequently asked questions and solutions for common issues in Opticas-Development.

---

## Table of Contents

- [Installation Issues](#installation-issues)
- [Database Issues](#database-issues)
- [API Issues](#api-issues)
- [Authentication Issues](#authentication-issues)
- [Docker Issues](#docker-issues)
- [Performance Issues](#performance-issues)
- [Deployment Issues](#deployment-issues)
- [Common Error Messages](#common-error-messages)
- [Where to Get Help](#where-to-get-help)

---

## Installation Issues

### Problem: "Composer install fails with permission errors"

**Error Message:**
```
Permission denied: /vendor/composer/
```

**Solution:**

```bash
# Fix permissions
sudo chown -R $USER:$USER ~/.composer/

# Or use Composer without superuser
mkdir -p vendor
composer install --no-plugins --no-scripts
```

### Problem: "PHP extensions missing"

**Error Message:**
```
Required PHP extension is missing: intl
```

**Solution:**

**Ubuntu/Debian:**
```bash
sudo apt install php8.1-intl php8.1-mbstring php8.1-mysql php8.1-gd php8.1-curl
```

**macOS:**
```bash
brew install php@8.1
```

### Problem: "Database connection fails"

**Error Message:**
```
Unable to connect to database: Connection refused
```

**Solution:**

1. Check MySQL is running:
   ```bash
   sudo systemctl status mysql
   # Or
   sudo service mysql status
   ```

2. Verify `.env` credentials:
   ```env
   database.default.hostname = localhost
   database.default.port = 3306
   database.default.username = root
   database.default.password = your_password
   database.default.database = optica_local
   ```

3. Test connection manually:
   ```bash
   mysql -u root -p optica_local
   ```

---

## Database Issues

### Problem: "Migration fails with table already exists"

**Error Message:**
```
Table 'sales' already exists
```

**Solution:**

```bash
# Rollback migrations
php spark migrate:rollback

# If rollback doesn't work, reset database
php spark migrate:refresh

# Or drop and recreate tables (DESTRUCTIVE!)
php spark migrate:fresh
```

### Problem: "Foreign key constraint fails"

**Error Message:**
```
Cannot add or update a child row: a foreign key constraint fails
```

**Solution:**

1. Check if referenced record exists:
   ```sql
   SELECT * FROM patients WHERE id = 123;
   ```

2. Ensure correct data type:
   ```sql
   SHOW CREATE TABLE patients;
   ```

3. Temporarily disable constraints (not recommended for production):
   ```sql
   SET FOREIGN_KEY_CHECKS = 0;
   -- Your operations
   SET FOREIGN_KEY_CHECKS = 1;
   ```

### Problem: "Slow query performance"

**Symptoms:**
- Pages load slowly
- Database queries take > 1 second

**Solution:**

1. Enable slow query log in MySQL config:
   ```ini
   slow_query_log = 1
   slow_query_log_file = /var/log/mysql/slow-query.log
   long_query_time = 2
   ```

2. Add missing indexes:
   ```sql
   CREATE INDEX idx_sales_date ON sales(created_at);
   CREATE INDEX idx_sale_items_sale ON sale_items(sale_id);
   ```

3. Optimize queries:
   ```sql
   EXPLAIN SELECT * FROM sales WHERE created_at > '2026-01-01';
   ```

4. Run table optimization:
   ```sql
   OPTIMIZE TABLE sales, sale_items, inventories;
   ```

---

## API Issues

### Problem: "401 Unauthorized"

**Error Message:**
```json
{
  "success": false,
  "error": "Unauthorized"
}
```

**Solution:**

1. Ensure token is included:
   ```http
   Authorization: Bearer your_token_here
   ```

2. Check token is not expired:
   ```bash
   # Decode JWT token (https://jwt.io/)
   # Check "exp" claim
   ```

3. Log in again to get fresh token:
   ```bash
   curl -X POST http://localhost:8080/api/auth/login \
     -H "Content-Type: application/json" \
     -d '{"email":"admin@example.com","password":"password"}'
   ```

### Problem: "422 Validation Error"

**Error Message:**
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "details": [
      {"field": "email", "message": "The email field is required."}
    ]
  }
}
```

**Solution:**

1. Check all required fields are present
2. Validate data types:
   ```json
   // Correct
   {"customer": 123}
   
   // Incorrect
   {"customer": "123"}  // Should be integer
   ```

3. Refer to API documentation for required fields:
   - [API Documentation](api/README.md)

### Problem: "429 Too Many Requests"

**Error Message:**
```json
{
  "success": false,
  "error": "Rate limit exceeded"
}
```

**Solution:**

1. Check rate limit headers:
   ```http
   X-RateLimit-Limit: 1000
   X-RateLimit-Remaining: 0
   X-RateLimit-Reset: 1643510400
   ```

2. Implement exponential backoff in your client:
   ```javascript
   function makeRequest(url) {
     return fetch(url)
       .catch(err => {
         if (err.status === 429) {
           // Wait and retry
           setTimeout(() => makeRequest(url), 5000);
         }
       });
   }
   ```

3. Contact support for increased limit if needed

---

## Authentication Issues

### Problem: "Cannot log in"

**Symptoms:**
- Invalid credentials error
- Login page not working

**Solution:**

1. Reset admin password:
   ```bash
   php spark auth:generate_password admin
   ```

2. Create new user:
   ```bash
   php spark auth:create admin@example.com admin --admin
   ```

3. Check Shield configuration:
   ```php
   // app/Config/Auth.php
   public array $redirects = [
       'register' => '/',
       'login' => '/',
   ];
   ```

### Problem: "Session expired frequently"

**Symptoms:**
- Logged out after few minutes
- Session lost on page refresh

**Solution:**

1. Check session configuration in `.env`:
   ```env
   session.driver = CodeIgniter\Session\Handlers\FileHandler
   session.expiration = 7200  # 2 hours
   session.savePath = WRITEPATH . 'session'
   ```

2. Verify writable directory permissions:
   ```bash
   chmod -R 777 writable/session
   ```

3. Check server session settings:
   ```php
   // php.ini
   session.gc_maxlifetime = 7200
   session.cookie_lifetime = 0
   ```

---

## Docker Issues

### Problem: "Container won't start"

**Symptoms:**
- `docker-compose up` fails
- Container exits immediately

**Solution:**

1. Check Docker is running:
   ```bash
   sudo systemctl status docker
   ```

2. View container logs:
   ```bash
   docker-compose logs app
   ```

3. Check port conflicts:
   ```bash
   lsof -i :8080
   ```

4. Rebuild image:
   ```bash
   docker-compose down
   docker-compose up -d --build
   ```

### Problem: "Cannot connect to database from inside container"

**Error Message:**
```
SQLSTATE[HY000] [2002] Connection refused
```

**Solution:**

1. Use Docker service name as hostname:
   ```env
   # In .env
   database.default.hostname = db  # NOT localhost
   ```

2. Check docker-compose.yml:
   ```yaml
   services:
     app:
       depends_on:
         - db
   ```

3. Verify database container is running:
   ```bash
   docker-compose ps
   ```

### Problem: "Volume permission errors"

**Error Message:**
```
Permission denied: /var/www/html/writable
```

**Solution:**

1. Fix permissions before building:
   ```bash
   sudo chown -R $USER:$USER writable/
   chmod -R 777 writable/
   ```

2. Add user to docker group:
   ```bash
   sudo usermod -aG docker $USER
   # Logout and login again
   ```

3. Use Docker's user mapping:
   ```yaml
   services:
     app:
       user: "${UID}:${GID}"
   ```

---

## Performance Issues

### Problem: "Page load is slow (> 3 seconds)"

**Symptoms:**
- Slow initial page load
- Delayed API responses

**Solution:**

1. Enable OPcache:
   ```ini
   ; php.ini
   opcache.enable=1
   opcache.memory_consumption=256
   opcache.max_accelerated_files=20000
   ```

2. Enable Redis cache:
   ```env
   ; .env
   cache.handler = Redis
   cache.redis.host = 127.0.0.1
   cache.redis.port = 6379
   ```

3. Optimize MySQL:
   ```ini
   ; my.cnf
   innodb_buffer_pool_size = 2G
   innodb_log_file_size = 512M
   query_cache_size = 64M
   ```

4. Enable gzip compression:
   ```nginx
   gzip on;
   gzip_types text/plain text/css application/json;
   ```

### Problem: "High memory usage"

**Symptoms:**
- OOM (Out of Memory) errors
- Server becomes unresponsive

**Solution:**

1. Check current memory usage:
   ```bash
   free -h
   ps aux --sort=-%mem | head
   ```

2. Adjust PHP memory limit:
   ```ini
   ; php.ini
   memory_limit = 128M
   ```

3. Optimize database connections:
   ```ini
   ; my.cnf
   max_connections = 100
   ```

4. Clear caches:
   ```bash
   php spark cache:clear
   ```

---

## Deployment Issues

### Problem: "502 Bad Gateway after deployment"

**Symptoms:**
- Nginx error after deployment
- Application not accessible

**Solution:**

1. Check PHP-FPM status:
   ```bash
   sudo systemctl status php8.1-fpm
   ```

2. Restart PHP-FPM:
   ```bash
   sudo systemctl restart php8.1-fpm
   ```

3. Check Nginx error log:
   ```bash
   tail -f /var/log/nginx/error.log
   ```

4. Verify socket exists:
   ```bash
   ls -la /var/run/php/php8.1-fpm.sock
   ```

### Problem: "SSL certificate error"

**Error Message:**
```
SSL_ERROR_BAD_CERT_DOMAIN
```

**Solution:**

1. Check certificate is valid:
   ```bash
   openssl x509 -in /path/to/cert.crt -text -noout
   ```

2. Renew Let's Encrypt certificate:
   ```bash
   sudo certbot renew
   ```

3. Verify domain in certificate:
   ```bash
   # Ensure domain matches
   commonName: opticas.tudominio.com
   ```

4. Restart Nginx:
   ```bash
   sudo systemctl restart nginx
   ```

---

## Common Error Messages

### Error: "Call to undefined function"

**Cause:** PHP extension missing

**Solution:**
```bash
sudo apt install php8.1-extension_name
sudo systemctl restart php8.1-fpm
```

### Error: "Class 'App\Models\SomeModel' not found"

**Cause:** Model file missing or wrong namespace

**Solution:**
```bash
# Check file exists
ls app/Models/SomeModel.php

# Verify namespace
namespace App\Models;

# Run composer dump-autoload
composer dump-autoload
```

### Error: "404 Not Found"

**Cause:** Route not configured or incorrect URL

**Solution:**
```php
// Check routes in app/Config/Routes.php
$routes->get('sale', 'Sale::index');

// Verify controller exists
ls app/Controllers/Sale.php

// Check HTTP verb (GET vs POST)
```

### Error: "500 Internal Server Error"

**Cause:** Unhandled exception

**Solution:**
```bash
# Check application logs
tail -f writable/logs/log-$(date +%Y-%m-%d).php

# Enable error reporting in .env
CI_ENVIRONMENT = development
logger.threshold = 9
```

### Error: "Failed to open stream: Permission denied"

**Cause:** File permission issue

**Solution:**
```bash
# Fix writable directory permissions
chmod -R 777 writable/

# Fix upload directory permissions
chmod -R 777 public/uploads/
```

---

## Debugging Tips

### Enable Debug Mode

Add to `.env`:
```env
CI_ENVIRONMENT = development
toolbar.enabled = true
logger.threshold = 9  # All levels
```

### View Application Logs

```bash
# View today's log
tail -f writable/logs/log-$(date +%Y-%m-%d).php

# View error log
tail -f writable/logs/error.log
```

### Check Database Queries

Add to `.env`:
```env
database.default.DBDebug = true
```

View queries in logs.

### Test API with curl

```bash
# Test endpoint with authentication
curl -X GET http://localhost:8080/api/patient \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

---

## Performance Tuning

### Quick Wins

1. **Enable OPcache** (automatic in PHP 7.0+)
2. **Enable Redis caching** for frequently accessed data
3. **Optimize database indexes** on slow queries
4. **Use CDN** for static assets
5. **Enable gzip compression** in web server

### Monitoring

```bash
# Check server resources
htop

# Check PHP-FPM status
systemctl status php8.1-fpm

# Check MySQL status
mysqladmin processlist
```

---

## Where to Get Help

### Documentation
- [README](../README.md)
- [API Documentation](api/README.md)
- [Deployment Guide](deployment/README.md)
- [Contributing Guide](../CONTRIBUTING.md)

### Community
- **GitHub Issues:** [Report bugs](https://github.com/tu-usuario/opticas-development/issues)
- **GitHub Discussions:** [Ask questions](https://github.com/tu-usuario/opticas-development/discussions)
- **Stack Overflow:** Tag with `opticas-development`

### Direct Support
- **Email:** soporte@opticas-development.local
- **WhatsApp:** +52 555 123 4567 (business hours only)
- **Slack:** #opticas-support

### Support Hours
- **Monday to Friday:** 9:00 AM - 6:00 PM CST
- **Saturday:** 9:00 AM - 2:00 PM CST
- **Sunday:** Closed

### Emergency Support
For critical production issues affecting business operations:
- **Phone:** +52 555 123 4567 (24/7 emergency line)
- **Email:** emergency@opticas-development.local

### Response Times
| Severity | Response Time | Examples |
|----------|----------------|----------|
| **Critical** | < 1 hour | System down, data loss |
| **High** | < 4 hours | Major feature broken |
| **Medium** | < 24 hours | Minor bug, workaround available |
| **Low** | < 72 hours | Enhancement request, documentation |

---

## Before Asking for Help

Please gather this information:

1. **Version Information**
   ```bash
   php -v
   mysql --version
   docker --version
   git log -1 --format="%H %s"
   ```

2. **Error Messages**
   - Full error message
   - Stack trace (if available)

3. **Steps to Reproduce**
   1. 
   2. 
   3. 

4. **Environment**
   - OS and version
   - Browser (if frontend issue)
   - Development or production

5. **What You Tried**
   - Steps taken to resolve issue
   - Results of troubleshooting

---

## Common Issues by Version

### Version 1.0.0

**Known Issues:**
- None reported yet

**Workarounds:**
- Report new issues to GitHub

---

**Last Updated:** January 29, 2026  
**Version:** 1.0.0  
**Maintainer:** Support Team

---

*Found this helpful? ⭐ Star us on GitHub to support the project!*

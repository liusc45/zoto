# Makefile for Opticas-Development Docker Setup
# Provides convenient commands for Docker operations

# ==========================================
# Configuration
# ==========================================
DOCKER_COMPOSE := docker-compose
EXEC_APP := docker-compose exec -T app
EXEC_DB := docker-compose exec -T db

# ==========================================
# Help
# ==========================================
.PHONY: help
help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Available targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

# ==========================================
# Development Commands
# ==========================================
.PHONY: dev
dev: ## Start development environment
	$(DOCKER_COMPOSE) --profile dev up -d
	@echo "✓ Development environment started"
	@echo "  Application: http://localhost:80"
	@echo "  phpMyAdmin: http://localhost:8081"

.PHONY: dev-build
dev-build: ## Build development images
	$(DOCKER_COMPOSE) --profile dev build --no-cache
	@echo "✓ Development images built"

.PHONY: dev-rebuild
dev-rebuild: ## Rebuild development images
	$(DOCKER_COMPOSE) --profile dev up -d --build --force-recreate
	@echo "✓ Development environment rebuilt"

# ==========================================
# Production Commands
# ==========================================
.PHONY: prod
prod: ## Start production environment
	$(DOCKER_COMPOSE) up -d
	@echo "✓ Production environment started"
	@echo "  Application: http://localhost:80"

.PHONY: prod-build
prod-build: ## Build production images
	DOCKER_BUILDKIT=1 docker-compose build --build-arg BUILD_TARGET=production
	@echo "✓ Production images built"

.PHONY: prod-rebuild
prod-rebuild: ## Rebuild production environment
	DOCKER_BUILDKIT=1 docker-compose up -d --build --force-recreate
	@echo "✓ Production environment rebuilt"

# ==========================================
# Service Management
# ==========================================
.PHONY: start
start: ## Start all services
	$(DOCKER_COMPOSE) up -d
	@echo "✓ Services started"

.PHONY: stop
stop: ## Stop all services
	$(DOCKER_COMPOSE) stop
	@echo "✓ Services stopped"

.PHONY: restart
restart: ## Restart all services
	$(DOCKER_COMPOSE) restart
	@echo "✓ Services restarted"

.PHONY: down
down: ## Stop and remove containers
	$(DOCKER_COMPOSE) down
	@echo "✓ Containers removed"

.PHONY: down-v
down-v: ## Stop containers and remove volumes (DESTRUCTIVE!)
	@echo "⚠️  This will delete all data!"
	@read -p "Are you sure? [y/N] " -n 1 -r; \
		echo $$REPLY; \
		if [ "$$REPLY" = "y" ]; then \
			$(DOCKER_COMPOSE) down -v; \
			echo "✓ Containers and volumes removed"; \
		fi

.PHONY: logs
logs: ## View logs from all services
	$(DOCKER_COMPOSE) logs -f

.PHONY: logs-app
logs-app: ## View application logs
	$(DOCKER_COMPOSE) logs -f app

.PHONY: logs-db
logs-db: ## View database logs
	$(DOCKER_COMPOSE) logs -f db

.PHONY: logs-caddy
logs-caddy: ## View Caddy logs
	$(DOCKER_COMPOSE) logs -f caddy

# ==========================================
# Application Commands
# ==========================================
.PHONY: migrate
migrate: ## Run database migrations
	$(EXEC_APP) php spark migrate
	@echo "✓ Migrations completed"

.PHONY: migrate-rollback
migrate-rollback: ## Rollback last migration
	$(EXEC_APP) php spark migrate:rollback
	@echo "✓ Migration rolled back"

.PHONY: migrate-fresh
migrate-fresh: ## Fresh migrations (DESTRUCTIVE)
	@echo "⚠️  This will delete all data!"
	@read -p "Are you sure? [y/N] " -n 1 -r; \
		echo $$REPLY; \
		if [ "$$REPLY" = "y" ]; then \
			$(EXEC_APP) php spark migrate:fresh; \
			echo "✓ Database migrated fresh"; \
		fi

.PHONY: seed
seed: ## Seed database with initial data
	$(EXEC_APP) php spark db:seed
	@echo "✓ Database seeded"

.PHONY: key
key: ## Generate encryption key
	$(EXEC_APP) php spark key:generate
	@echo "✓ Encryption key generated"

.PHONY: test
test: ## Run tests
	$(EXEC_APP) vendor/bin/phpunit
	@echo "✓ Tests completed"

.PHONY: test-coverage
test-coverage: ## Run tests with coverage
	$(EXEC_APP) vendor/bin/phpunit --coverage-html coverage
	@echo "✓ Tests completed with coverage"

.PHONY: cache-clear
cache-clear: ## Clear application cache
	$(EXEC_APP) php spark cache:clear
	@echo "✓ Cache cleared"

.PHONY: optimize
optimize: ## Optimize application
	$(EXEC_APP) composer dump-autoload --optimize --classmap-authoritative
	@echo "✓ Application optimized"

# ==========================================
# Database Commands
# ==========================================
.PHONY: db-connect
db-connect: ## Connect to database shell
	$(EXEC_DB) mysql -u root -proot optica_local

.PHONY: db-backup
db-backup: ## Backup database
	$(EXEC_DB) mysqldump -u root -proot optica_local > backup_$(shell date +%Y%m%d_%H%M%S).sql
	@echo "✓ Database backed up"

.PHONY: db-restore
db-restore: ## Restore database (usage: make db-restore FILE=backup.sql)
	@if [ -z "$(FILE)" ]; then \
		echo "Error: FILE parameter required. Usage: make db-restore FILE=backup.sql"; \
		exit 1; \
	fi
	cat $(FILE) | $(EXEC_DB) mysql -u root -proot optica_local
	@echo "✓ Database restored from $(FILE)"

.PHONY: db-import
db-import: ## Import SQL file (usage: make db-import FILE=import.sql)
	@if [ -z "$(FILE)" ]; then \
		echo "Error: FILE parameter required. Usage: make db-import FILE=import.sql"; \
		exit 1; \
	fi
	cat $(FILE) | $(EXEC_DB) mysql -u root -proot optica_local
	@echo "✓ Database imported from $(FILE)"

# ==========================================
# User Management
# ==========================================
.PHONY: user-create
user-create: ## Create admin user (usage: make user-create EMAIL=admin@example.com PASSWORD=secret)
	$(EXEC_APP) php spark auth:create $(EMAIL) $(PASSWORD)
	@echo "✓ User created: $(EMAIL)"

.PHONY: user-password
user-password: ## Reset user password (usage: make user-password EMAIL=admin@example.com)
	$(EXEC_APP) php spark auth:generate_password $(EMAIL)
	@echo "✓ Password reset for: $(EMAIL)"

# ==========================================
# Maintenance
# ==========================================
.PHONY: clean
clean: ## Clean up stopped containers and unused images
	docker container prune -f
	docker image prune -f
	@echo "✓ Cleanup completed"

.PHONY: clean-all
clean-all: ## Clean all Docker resources (DESTRUCTIVE!)
	@echo "⚠️  This will delete all containers, images, and volumes!"
	@read -p "Are you sure? [y/N] " -n 1 -r; \
		echo $$REPLY; \
		if [ "$$REPLY" = "y" ]; then \
			docker system prune -a --volumes; \
			echo "✓ All Docker resources cleaned"; \
		fi

.PHONY: update
update: ## Update Docker images
	docker-compose pull
	$(DOCKER_COMPOSE) up -d
	@echo "✓ Images updated"

.PHONY: build
build: ## Build all images
	$(DOCKER_COMPOSE) build --no-cache
	@echo "✓ Images built"

.PHONY: rebuild
rebuild: ## Rebuild all images
	$(DOCKER_COMPOSE) up -d --build --force-recreate
	@echo "✓ Images rebuilt"

# ==========================================
# Monitoring
# ==========================================
.PHONY: ps
ps: ## Show running containers
	$(DOCKER_COMPOSE) ps

.PHONY: stats
stats: ## Show container resource usage
	docker stats --no-stream

.PHONY: health
health: ## Show health status
	@docker-compose ps --format "table {{.Name}}\t{{.Status}}\t{{.State}}"

# ==========================================
# Setup
# ==========================================
.PHONY: setup
setup: ## Initial setup (first time run)
	@echo "Setting up Opticas-Development..."
	cp .env.docker.example .env
	@echo "✓ .env created from .env.docker.example"
	@read -p "Edit .env and press Enter to continue..."
	$(DOCKER_COMPOSE) --profile dev up -d
	@echo "✓ Waiting for services to be ready..."
	@sleep 10
	$(EXEC_APP) composer install
	@echo "✓ Dependencies installed"
	$(EXEC_APP) php spark migrate
	@echo "✓ Database migrated"
	$(EXEC_APP) php spark key:generate
	@echo "✓ Encryption key generated"
	@echo ""
	@echo "✓ Setup complete!"
	@echo "  Application: http://localhost:80"
	@echo "  phpMyAdmin: http://localhost:8081"
	@echo "  Default admin: admin@opticas.local / admin"

# ==========================================
# Default Target
# ==========================================
.DEFAULT_GOAL := help

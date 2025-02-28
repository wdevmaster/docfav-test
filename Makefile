# Variables
DOCKER_COMPOSE = docker compose
DOCKER_EXEC_APP = $(DOCKER_COMPOSE) exec app
DOCKER_EXEC_MYSQL = $(DOCKER_COMPOSE) exec mysql

DB_PASSWORD = $$(grep DB_PASSWORD .env | cut -d '=' -f2)
DB_DATABASE = $$(grep DB_DATABASE .env | cut -d '=' -f2)

# Reglas
.PHONY: setup up down composer-install create-db migrate test

# Regla para la configuración inicial del proyecto
setup:
	@echo "Configurando el proyecto..."
	@cp .env.example .env
	@echo "Archivo .env creado a partir de .env.example"
	@$(DOCKER_COMPOSE) build
	@echo "Imágenes de Docker construidas"
	@$(DOCKER_COMPOSE) up -d
	@echo "Servicios levantados en segundo plano"
	@$(MAKE) composer-install
	@$(MAKE) create-db
	@$(MAKE) migrate
	@echo "Proyecto configurado"

up:
	@$(DOCKER_COMPOSE) up -d

down:
	@$(DOCKER_COMPOSE) down

composer-install:
	@$(DOCKER_EXEC_APP) composer install
	@echo "Dependencias de PHP instaladas"

create-db:
	@$(DOCKER_EXEC_MYSQL) mysql -u root -p$(DB_PASSWORD) -e "CREATE DATABASE IF NOT EXISTS $(DB_DATABASE);"
	@echo "Base de datos creada"

migrate:
	@$(DOCKER_EXEC_APP) ./doctrine migrations:migrate --no-interaction --all-or-nothing

test:
	@$(DOCKER_EXEC_APP) ./vendor/bin/phpunit
	@echo "Tests ejecutados"
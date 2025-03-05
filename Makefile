# Подключаем файл .env и экспортируем переменные
include .env
export $(shell sed 's/=.*//' .env)

APP_CONTAINER_NAME = app
HORIZON_CONTAINER_NAME = horizon

# Определяем файл docker-compose на основе ENV
ifeq ($(APP_ENV), production)
  COMPOSE_FILE = docker-compose.prod.yml
else
  COMPOSE_FILE = docker-compose.yml
  APP_CONTAINER_NAME = laravel.test
  HORIZON_CONTAINER_NAME =
endif

# Команды
up:
	docker compose -f $(COMPOSE_FILE) up -d

down:
	docker compose -f $(COMPOSE_FILE) down

logs:
	docker compose -f $(COMPOSE_FILE) logs -f

build:
	docker compose -f $(COMPOSE_FILE) build

update-app:
	docker rollout -f $(COMPOSE_FILE) $(APP_CONTAINER_NAME)

update-horizon:
	docker rollout -f $(COMPOSE_FILE) $(HORIZON_CONTAINER_NAME)

# Команда для входа в консоль контейнера app
enter:
	docker compose -f $(COMPOSE_FILE) exec $(APP_CONTAINER_NAME) /bin/bash

tinker:
	docker compose -f $(COMPOSE_FILE) exec $(APP_CONTAINER_NAME) php artisan tinker

migrate:
	docker compose -f $(COMPOSE_FILE) exec $(APP_CONTAINER_NAME) php artisan migrate

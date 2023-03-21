SHELL := /bin/bash

.SILENT: ;
.ONESHELL: ;
.EXPORT_ALL_VARIABLES: ;

.PHONY: up
up:
	docker compose --env-file .env up -d --force-recreate

.PHONY: down
down:
	docker-compose down

.PHONY: build
build:
	docker compose --env-file .env build --no-cache

.PHONY: bash
bash:
	docker exec -it hillel-app bash

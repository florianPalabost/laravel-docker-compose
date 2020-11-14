DOCKER_COMPOSE := docker-compose
PHP_EXEC := $(DOCKER_COMPOSE) exec -w /var/www/html php
WEB_EXEC := $(DOCKER_COMPOSE) exec -w /var/www/html web
NPM_EXEC := $(DOCKER_COMPOSE) exec -w /var/www/html npm

## Global commands
install:
	./start.sh
	$(PHP_EXEC) composer install
	echo 'cp .env (vars global) & html/.env (for laravel vars project) if not done & fill the different vars.'

start: ## down rmi all & up --build
	./start.sh

stop:
	$(DOCKER_COMPOSE) stop

down:
	$(DOCKER_COMPOSE) down --rmi all

npm-install: ## install all dep or few deps
	@$(NPM_EXEC) i $@

npm-watch: ## compile scss & js files
	@$(NPM_EXEC) run watch

logs:
	$(DOCKER_COMPOSE) logs -f

clean:
	$(MAKE) down
	@rm -rf var/ html/vendor/ html/node_modules/

## Project commands
analyze: ## larastan, eslint ?
	@$(PHP_EXEC) vendor/bin/phpstan analyze --memory-limit 1G
	@$(WEB_EXEC)

phpunit:
	@$(PHP_EXEC) vendor/bin/phpunit

route:
	@$(PHP_EXEC) php artisan route:list

migrate:
	@$(PHP_EXEC) php artisan migrate

queue-retry:
	@$(PHP_EXEC) php artisan queue:retry all

queue-start:
 	@$(PHP_EXEC) php artisan queue:work --tries 1
DOCKER_COMPOSE := docker-compose
PHP_EXEC := $(DOCKER_COMPOSE) exec -w /var/www/html php
WEB_EXEC := $(DOCKER_COMPOSE) exec -w /var/www/html web
NPM_EXEC := $(WEB_EXEC) npm

# for use args commands and be able to use args like make:controller
# to use args like --unit use : " --unit"
COMMAND_ARGS := $(subst :,\:,$(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS)))

## Global commands todo color logs & echo & errors
toto:
	echo COMMAND_ARGS
	#$(PHP_EXEC) php artisan

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
	$(NPM_EXEC) i $(COMMAND_ARGS)

npm-watch: ## compile scss & js files
	@$(NPM_EXEC) run watch

logs:
	$(DOCKER_COMPOSE) logs -f

cache-clear:
	@$(PHP_EXEC) php artisan config:clear
	@$(PHP_EXEC) php artisan cache:clear
	@$(PHP_EXEC) php artisan view:clear

clean:
	$(MAKE) down
	@rm -rf var/ html/vendor/ html/node_modules/

## Project commands
pa:
	@$(PHP_EXEC) php artisan $(COMMAND_ARGS)

analyze: ## larastan, eslint ?
	@$(PHP_EXEC) vendor/bin/phpstan analyze --memory-limit 1G

phpunit:
	@$(PHP_EXEC) php artisan migrate:refresh --env=testing
	@$(PHP_EXEC) vendor/bin/phpunit

code-coverage:
	@$(PHP_EXEC) vendor/bin/phpunit --coverage-html tests/reports/

route:
	@$(PHP_EXEC) php artisan route:list

migrate:
	@$(PHP_EXEC) php artisan migrate

queue-retry:
	@$(PHP_EXEC) php artisan queue:retry all

queue-start:
 	@$(PHP_EXEC) php artisan queue:work --tries 1
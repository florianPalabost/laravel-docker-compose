DOCKER_COMPOSE := docker-compose
PHP_EXEC := $(DOCKER_COMPOSE) exec -w /var/www/html php
WEB_EXEC := $(DOCKER_COMPOSE) exec -w /var/www/html web
NPM_EXEC := $(WEB_EXEC) npm

# for use args commands and be able to use args like make:controller
# to use args like --unit use : " --unit"
COMMAND_ARGS := $(subst :,\:,$(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS)))

## Global commands
## help: 	help command
help : Makefile
	@sed -n 's/^##//p' $<

## install: 	Install project
install:
	./start.sh
	$(PHP_EXEC) composer install
	echo 'cp .env (vars global) & html/.env (for laravel vars project) if not done & fill the different vars.'

## start: 	Just start all dockers (down rmi all & up --build)
start:
	./start.sh

## stop: 	Stop all containers
stop:
	$(DOCKER_COMPOSE) stop

## down: 	Stop all containers & kill them
down:
	$(DOCKER_COMPOSE) down --rmi all

## npm-install: 	Install all deps or the one specify in args
npm-install:
	$(NPM_EXEC) i $(COMMAND_ARGS)

## npm-watch: 	Compile scss & js files
npm-watch:
	@$(NPM_EXEC) run watch

## logs: 	Log all container
logs:
	$(DOCKER_COMPOSE) logs -f

## cache-clear: 	Clear all cache
cache-clear:
	@$(PHP_EXEC) php artisan config:clear
	@$(PHP_EXEC) php artisan cache:clear
	@$(PHP_EXEC) php artisan view:clear

## clean: 	Clean reps
clean:
	$(MAKE) down
	@rm -rf var/ html/vendor/ html/node_modules/

## Project commands

## pa: 	php artisan commands
pa:
	@$(PHP_EXEC) php artisan $(COMMAND_ARGS)

## c-req: 	Install dep specify in args
c-req:
	@$(PHP_EXEC) composer require $(COMMAND_ARGS)

## analyze: 	Analyse code (valid composer, phpstan, phpcbf & npm audit)
analyze:
	@$(PHP_EXEC) composer valid
	@$(PHP_EXEC) vendor/bin/phpcbf $(COMMAND_ARGS) -d " memory_limit=256M"
	@$(PHP_EXEC) vendor/bin/phpstan analyze --memory-limit 1G
	@$(NPM_EXEC) audit

## phpcbf: 	rep, php code beautifer & fixer
phpcbf:
	@$(PHP_EXEC) vendor/bin/phpcbf $(COMMAND_ARGS) -d " memory_limit=256M"

## phpunit: 	Run tests (refresh db before)
phpunit:
	@$(PHP_EXEC) php artisan migrate:refresh --env=testing
	@$(PHP_EXEC) vendor/bin/phpunit

## code-coverage: 	Run tests & generate reports in (html/tests/reports/)
code-coverage:
	@$(PHP_EXEC) vendor/bin/phpunit --coverage-html tests/reports/

## route: 	List all routes
route:
	@$(PHP_EXEC) php artisan route:list

## migrate: 	Run migrations
migrate:
	@$(PHP_EXEC) php artisan migrate

## queue-retry: 	Add to queue all items which failed
queue-retry:
	@$(PHP_EXEC) php artisan queue:retry all

## queue-start: 	Run queue with one try
queue-start:
 	@$(PHP_EXEC) php artisan queue:work --tries 1
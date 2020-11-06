# Requirements
- Docker & Docker-compose installed

## Install
- run
    - ````./start.sh````
    - ```docker-compose exec -w /var/www/html php composer install (1st time)```
- compile sass & js (dev) 
    - ````npm run watch````

## Routes
- import all animes
    - ````php artisan command:import````

## Dev
- Analyse code 
    - ```vendor/bin/phpstan analyse```

- Queue
    - start
        - ```docker-compose exec -w /var/www/html php php artisan queue:work --tries=1```
    - restart
        - ```docker-compose exec -w /var/www/html php php artisan queue:retry all```

- Cache
    -  ```docker-compose exec -w /var/www/html php artisan <config:clear, cache:clear, view:clear>```
## Composer & artisan 
- ```docker-compose exec -w /var/www/html php <composer, artisan> ...```

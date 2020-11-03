# Laravel + Docker + PHP 7.3 (with composer) + PostgreSQL starter pack

Use a starter pack to start developing apps using [Laravel](https://laravel.com/) in just a few minutes.

**Starter pack includes:**
* nginx
* PHP 7.3
* Composer
* PostgreSQL 12
* Laravel starter code
* pgAdmin 4.27
* redis

# Getting started

## Prerequisites

Having `docker` and `docker-compose` installed.

## Installation

1. Clone the project and bring the containers up:
    ```bash
    git clone <URL_REP> ./
    ./start.sh
    ```
1. install composer packages:
    ```bash
    docker-compose exec -w /var/www/html php composer install
    ```
1. Navigate to [http://localhost:8080](http://localhost:8080)
4. Done!

## Connecting to Postgres

Database created by default and that should be used for your application is `app`.
Username is `docker` and password is `secret`.

To connect to postgres DB from `php` application use `db` as a host name and default port (`5432`).

To connect from the host machine use `localhost` as the host name and port `54321`.

## Running `artisan` commands (ex. migrations)

```bash
docker-compose exec -w /var/www/html php php artisan <command>
```

# License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

# Project Management
## Requirements

Make sure your development environment meets the following requirements:

- PostgreSQL
- Redis
- PHP 7.4 or higher (Preferably 7.4)
- Node 10 or higher (Preferably 14)

### Using docker


For setting up development environment, use [sun-asterisk-research/docker-php-development](https://github.com/sun-asterisk-research/docker-php-development).
Follow the instruction there to set up your development environment. Use at least the following services

```text
php
web
postgres
redis
```

For accessing web UI & api via the same domain, override docker compose by creating `docker-compose.override.yml` file in docker project:
```yaml
version: '2.2'

services:
  nginx:
    labels:
      - traefik.http.middlewares.${COMPOSE_PROJECT_NAME}-api-stripprefix.stripprefix.prefixes=${API_PATH_PREFIX:-/}

```

You may add `pgadmin` to access the database, it will be available at `${DOMAIN_BACKEND}:${PORT}/pgadmin`.

## Installation

Follow the instructions to install both the [API](api) and the [web app](web).

## Running tests

When using docker, PHP test cases must be run inside the `php` container.

```sh
./project sh php
```

When inside the container, run tests with

```sh
composer test
```

Make sure all test cases have passed locally before you commit your works.

## Coding Style

To check your code for style & conventions, run:

```sh
make lint
```

Make sure your code follows the coding convention before committing your works.

### PHP

PHP code follows [sun-asterisk/coding-standard](https://github.com/sun-asterisk-research/php-coding-standard).

To run `phpcs`, enter the `api` directory and run:

```sh
composer sniff
```

Errors marked as fixable can be fixed automatically with:

```sh
composer autofix
```

### JavaScript

JavaScript code follows our own defined ruleset.

To run `eslint` to check your code, enter the `web` directory and run:

```sh
yarn lint
```

Errors marked as fixable can be fixed automatically with:

```sh
yarn lint --fix
```

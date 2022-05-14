# Products Monitoring

Products Monitoring API & job coordinator.

## Installation

When using docker, `composer` commands must be run inside the `php` container.

```sh
./project sh php
```

Install dependencies.

```sh
composer install
```

Make a `.env` file. Make sure NOT to run this inside the container to avoid permission issue.

```sh
cp .env.example .env
```

Change environment variables to fit your needs.
The api should be available at `$HOST/api` with the `HOST` you set in your docker `.env` file.

### Enable telescope

Publish telescope assets

```sh
php artisan telescope:publish
```

Add telescope host config. Create a `docker-compose.override.yml` file in docker project and add the following

```yml
version: '2.2'

#...

services:
  nginx:
    labels:
      - traefik.http.routers.telescope.rule=Host(`${DOMAIN}`) && (PathPrefix(`/telescope`) || PathPrefix(`/vendor`))
      - traefik.http.routers.telescope.service=${COMPOSE_PROJECT_NAME}-nginx
      - traefik.http.routers.tunnel.rule=Host(`${TUNNEL_DOMAIN}`)
      - traefik.http.routers.tunnel.service=${COMPOSE_PROJECT_NAME}-nginx
      - traefik.http.middlewares.${COMPOSE_PROJECT_NAME}-api-stripprefix.stripprefix.prefixes=${API_PATH_PREFIX:-/}
```

### Add more domain to allow access from the internet

To add more domain for accessing the local development site from the internet (e.g. for receiving webhooks),
add the following labels to the caddy services in your `docker-compose.override.yml`

```yml
version: '2.2'

#...

services:
  nginx:
    labels:
      - traefik.http.routers.tunnel.rule=Host(`${TUNNEL_DOMAIN}`)
      - traefik.http.routers.tunnel.service=${COMPOSE_PROJECT_NAME}-nginx

#...
```

Then set the value for `TUNNEL_DOMAIN` in your docker project's `.env` file.

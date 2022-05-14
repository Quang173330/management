# Products monitoring web

Products monitoring web app.

## Installation

When using docker, `yarn` commands must be ran inside the `web` container.

```sh
./project sh web
```

Install dependencies.

```sh
yarn install
```

Make a `.env` file. Make sure NOT to run this inside the container to avoid permission issue.

```sh
cp .env.example .env
```

## Development

To start the dev server, enter the `web` container and run:

```sh
yarn dev
```

The web server will be available at the `HOST` you set in the docker `.env` file.

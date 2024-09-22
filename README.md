# Car Catalogue

a CRUD For Car Catalogues

## Technologies

| Type        | Name / Version |
| ----------- | -------------- |
| php         | 8.3            |
| laravel     | 11             |
| docker      | laravel/sail   |


## Prerequisites

- install [docker](https://docs.docker.com/engine/install/)
- start docker

## Setup

```shell
git clone git@github.com:devtantawy/car-catalogue.git car-catalogue
```

- `cd car-catalogue`
- optional: [configuring a shell alias for sail](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias)
- install dependencies `composer install`

- duplicate `.env.example` to `.env`

- run sail `make up`

- run `make local-setup`

> now you can access the app in your browser by using `localhost`

## Usage

| Command          | Meaning                                                   |
| ---------------- | --------------------------------------------------------- |
| `make up`        | `sail up -d`                                              |
| `make down`      | `sail down`                                               |
| `make restart`   | `make down; make up;`                                     |
| `make test`      | `sail test`                                               |
| `make migrate`   | migrate db & seed                                         |
| `make stan`      | run phpstan                                               |
| `make cs-fixer`  | run php-cs-fixer                                          |
| `make phpmd`     | run phpmd                                                 |
| `make f-lint`    | run frontend linters                                      |
| `make ci`        | run all linters/fixers + tests                            |
| `make post-pull` | make sure to have all the needed setup for the new branch |

## Troubleshooting

1. opened `localhost` and page is blank ?
    - make sure `docker` is running
    - make sure no other containers are running with the same ports
    - make sure you have executed `make up`

3. i uploaded a file & i cant render it on the browser ?
    - use `Storage::url($your_uploaded_file_path)`

## Larave Passport for authentication

run `./vendor/bin/sail artisan passport:install --force` to install passport if migration files are not installed

navigate into `/api/register` to create a new access token to use the api
add the token in authorization `Bearer {Token}`

## Code Of Conduct

- always run `make ci` & fix any errors before committing your changes.
- any default `env` keys should be added to
    - `.env._local` for local
    - `.env.example` for production

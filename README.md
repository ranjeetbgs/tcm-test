<p align="center">
    <img src="https://media.githubusercontent.com/media/thecodingmachine/symfony-boilerplate/v2/docs/logo_boilerplate.svg" alt="Symfony Boilerplate" width="250" height="250" />
</p>
<h3 align="center">Symfony Boilerplate V2 + TCM Test</h3>
<p align="center"><a href="https://thecodingmachine.github.io/symfony-boilerplate">Documentation</a></p>


---

This is a template of a *README*. Adapt it according to the comments and your needs.

---

# Symfony Boilerplate

> Replace this title and the following description with your project name and description.

A web application built with Nuxt 3, Symfony 6.4 (LTS), and Docker.

## Get help

```
make help
```
This will display help

## Prerequisites

### Linux

Install the latest version of [Docker](https://docs.docker.com/install/) and
[Docker Compose](https://docs.docker.com/compose/install/).

### macOS

Consider installing [Orbstack](https://orbstack.dev/) as a drop-in replacement of Docker Desktop

## Setup

This boilerplate is best to use at the start of the project

### Starting a new project

1. clone Git repository on the platform of your choice:

```
git clone https://github.com/ranjeetbgs/tcm-test.git
```

2. Update the .env.dist accoding to your need. Minimal configuration to update:

```
APP_NAME
DATABASE_PASSWORD
DATABASE_USERNAME
SF_APP_SECRET
```

### First setup on local environment

When cloning your project, you need to 

- Copy a .env.dist as a .env
- Create expected values into your "/etc/hosts"
- Copy docker-compose.override.yml.template into docker-compose.override.yml

### Hosts

Update your `hosts` file with the following entries:

```
127.0.0.1   traefik.boilerplatev2.localhost
127.0.0.1   boilerplatev2.localhost
127.0.0.1   api.boilerplatev2.localhost
127.0.0.1   phpmyadmin.boilerplatev2.localhost
127.0.0.1   minio.boilerplatev2.localhost
127.0.0.1   mailhog.boilerplatev2.localhost
```

> Update the domain with the one used in your project.

On Linux and macOS, run `sudo nano /etc/hosts` to edit it.

On Windows, edit the file `C:\Windows\System32\drivers\etc\hosts` with administrative privileges.



A specific makefile task has been created:

```
make init-dev
```

### Start the project

You can start the project with usual docker compose command `docker compose up -d`


A specific makefile task has been created: `make up`
You can stop logging with `Ctrl+C`
Then, you can init the database: `make reset-db`


# Merge request checklist:

- if entities has changed, a new migration should be created

### Error

@see https://datatracker.ietf.org/doc/html/rfc7807 via  symfony/serializer-pack and https://symfony.com/doc/current/controller/error_pages.html

For loggin:  Monolog\Formatter\JsonFormatter (this is WIP)
## Database

### Update the database
The database access is configured directly via the environment variable "DATABASE_URL", In dev:

#### HOW TO

- In development

During development it is safe to assume:

```
db-dev-mig
```

working

- For production

To deploy new structures in production (IE mapping update):
1. Reset the database `make reset-db`
2. Generate a migration `make db-mig-diff`

3. Apply the migration

```
make migrate
```

# BASICS

## How the backend it has been created
```
docker run --rm  --volume=`pwd`/app:/usr/src/app/:rw thecodingmachine/php:8.0-v4-apache -- bash -c "cd '/usr/src/app/' && composer create-project symfony/skeleton backend"
```
## Install dummy data
```
docker compose exec back php bin/console doctrine:fixtures:load

this will create following two users
1. admin@tcm.com | password : admin
2. user@tcm.com | password : user

and create 5 transaction for both user
```

## Install composer package inside the project
```
docker run --rm  --volume=`pwd`/app/backend:/usr/src/app/:rw thecodingmachine/php:8.0-v4-apache -- bash -c "cd '/usr/src/app/' && composer require mypackage"
```

## Run a command
```
docker run --rm  --volume=`pwd`/app/backend:/usr/src/app/:rw thecodingmachine/php:8.0-v4-apache -- bash -c "cd '/usr/src/app/' && php bin/console debug:config monolog"
```

## Must to read

https://symfony.com/doc/current/configuration.html#configuration-environments

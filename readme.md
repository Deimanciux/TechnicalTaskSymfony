# Introduction
- Application for a teacher to assign students to groups for a project. Created on Symfony framework, MySQL database.

# Specifications

- php 7.4
- symfony 5.2.3
- mysql 8
- yarn 1.22.5
- node 15.8.0
- Bootstrap 4.6.0

## Installation

- clone project from git repository

- run docker containers
```bash
docker-compose up -d
```

- install dependencies
```bash
docker exec -it php74-container-docker bash
composer install
```

- install yarn
```bash
docker-compose run --rm node-service yarn install
```

- install assets
```bash
docker-compose run --rm node-service yarn encore dev
```

- create database and run migrations
```bash
docker exec -it php74-container-docker bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
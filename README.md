
# Subscription API

This codebase is for a test assignment and this is my implementation

## What's inside
- Docker wrapper for a PHP project with nginx, mysql, phpmyadmin, redis and composer.
- A PHP implementation of a sample subscription API.

## Instructions on how to run:
After cloning this project, build the docker container by running command:
> docker-compose up -d --build

Subsequent runs just require
> docker-compose up -d

To stop docker:
> docker-compose down

## Other commands:

By Default, the container automatically runs composer. To run composer manually:
> docker-composer run --rm composer (command here, e.g. install, update, new package)

## API Endpoints:
**GET Request** Getting list of subscribers:
> http://localhost/subscribers

**GET Request** Getting a single subscriber:
> http://localhost/subscribers/get/?id={id}

**POST Request** Adding a new subscriber:
> http://localhost/subscriber/add

## Other Features:
- To scale the API requests, I've implemented caching using redis and added rate limiters for get requests.
- For a simple frontend implementation, I used Vue and Tailwind.

## Packages Used:
- vlucas/phpdotenv
- thingengineer/mysqli-database-class
- predis/predis
- palepurple/rate-limit
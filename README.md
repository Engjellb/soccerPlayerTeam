# Soccer player team app

##### Soccer player team contains state and behaviour of the players. The player has a position and skills that corresponds for that one. It is organized with roles and permissions. The teams have their own players and a super admin has access for the teams.

----------

# Getting started

## Installation

#### Prerequisites

&emsp;&emsp;* **PHP 8.0+**<br/>
&emsp;&emsp;* **Composer (latest version)**<br/>
&emsp;&emsp;* **MySQL or PostgreSQL (Used within docker compose)**



Check the official laravel installation guide for further information. [Official Documentation](https://laravel.com/docs/9.x/installation)

Alternative installation is possible without local dependencies relying on [Docker](https://www.docker.com).

Clone the repository

    git clone git@github.com:Engjellb/soccerPlayerTeam.git

Switch to the repo folder

    cd soccerPlayerTeam

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Create encryption keys for generating secure access tokens

    php artisan passport:install

Run the database migrations and seeders (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:Engjellb/soccerPlayerTeam.git
    cd soccerPlayerTeam
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan passport:install 

**Make sure you set the correct database connection information before running the migrations with seeders**

    php artisan migrate --seed
    php artisan serve

You can run features and units tests
    
    php artisan test

To generate api documentation you need to set value of `L5_SWAGGER_GENERATE_ALWAYS` to `True`, otherwise run the command
    
    php artisan l5-swagger:generate

Access api documentation at http://localhost:8000/api/v1/documentation

## Docker

To install with [Docker](https://www.docker.com), run following commands:

```
git clone git@github.com:Engjellb/soccerPlayerTeam.git
cd soccerPlayerTeam
cp .env.example.docker .env
docker-compose up -d
docker ps (Copy <CONTAINER ID> of soccerPlayerTeamApp container)
docker exec -it <CONTAINER ID> bash
composer install
php artisan key:generate
php artisan passport:install
php artisan migrate --seed
php artisan test
```

The api can be accessed at [http://localhost:8000/api/v1](http://localhost:8000/api/v1).

----------

# Dependencies

- [Passport](https://laravel.com/docs/9.x/passport) - For authentication using JSON Web Tokens
- [Spatie-permission](https://spatie.be/docs/laravel-permission/v5/introduction) - For managing roles and permissions
- [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) - Generate API documentation

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api/v1

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Optional 	| Authorization    	| Bearer {JWT}      	|

----------

# Authentication

This application uses JSON Web Token (JWT) to handle authentication. The token is passed with request on protected routes using the `Authorization` header with `Bearer` scheme. The `auth:api` middleware handles the validation and authentication of the token.

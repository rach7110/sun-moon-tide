# Project Title

This API is for users who want to know what the sun, moon, and tides are doing. It is useful for photographers who like to shoot at night when the tide is low, the moon is full, and the sun is set. Or anyone else who is interested in celestial information at high and low tide.

## Live Site
TODO
## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

The things you need before installing the application.

* Laravel 8.40
* Composer 2.2.5
* PHP 8.0
* mysql 14.14
### Installation

A step by step guide that will tell you how to get the development environment up and running.

```
$ git clone https://github.com/rach7110/sun-moon-tide
$ cd sun-moon-tide
$ composer install

# Start the development server
$ php artisan serve

# Once you have started the Artisan development server, you may access your application at http://localhost:8000

# Create a file for local environment variables from the blueprint.
$ cp .env.example .env

# Set your database variables in .env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE={your_db_name}
DB_USERNAME={your_username}
DB_PASSWORD={your_password}

# Migrate the database tables
$ php artisan migrate
```

## Usage
TODO
A few examples of useful commands and/or tasks.

```
$ First example
$ Second example
$ And keep this in mind

The API endpoints can be reached from these URLs:
```
### Branches
TODO
* Master:
* Feature:
* Bugfix:
* etc...

## Additional Documentation
 * [Queues](#queues)
 * [Commands](#commands)
 * [Testing](#testing)
 * [Events](#events)

#### Queues:
Class                       | Description
----------------------------|---------------------------------------------------------------------------------
* App/Jobs/UpdateNoaaBuoys  | Gets the list of noaa buoy ids from external api. Updates list in a local file.

#### Commands:
Name                    | Description
------------------------|---------------------------------------------------------------------------------
updateBuoys             | Checks if there are changes to the NOAA buoy identifiers and stores in a local file.

#### Testing
TODO
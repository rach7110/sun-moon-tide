# Sun Moon Tide

This API is for users who want to know what the sun, moon, and tides are doing. It is useful for photographers who like to shoot at night when the tide is low, the moon is full, and the sun is set. Or anyone else who is interested in celestial information at high and low tide.

## Live Site
http://5.161.125.254/
## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

* Laravel 8.40
* Composer 2.2.5
* PHP 8.0
* MySQL 14.14
* Node 12.18
### Installation

A step by step guide that will tell you how to get your development environment up and running.

```
$ git clone https://github.com/rach7110/sun-moon-tide
$ cd sun-moon-tide

# Install php dependencies
$ composer install

# Install JavaScript dependencies and compile assets
$ npm install
$ npm run dev

# Start the development server
$ php artisan serve

# Once you have started the Artisan development server,
# you may access your application at http://localhost:8000

# Create a file for local environment variables from the template.
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
Before using the web application or the API, you must first register a user account.

Web Application
After registering a user account, you may access the app through the web browser which stores a session authentication cookie.

API
Alternatively, there is an API that returns a json object with the climate data. To access the API, you will first need to generate a token using your email and password.
Send a request to `{address}/api/tokens/create` with your credentials in a json object in the request body. Example:
`{"email":"{{email_prod}}","password":"{{password_prod}}"}`

Copy the token from the response.

Next, send a POST request to `{address}/api/climate`. In the request Header, include a `Authorization` key with a value of `Bearer:  {your_token}`

### Branches
TODO
* Master:
* Feature:
* Bugfix:

## Additional Documentation
 * [Queues](#queues)
 * [Commands](#commands)
 * [Testing](#testing)
 * [Events](#events)

#### Queues:
Class                       | Description
----------------------------|---------------------------------------------------------------------------------
App/Jobs/UpdateNoaaBuoys  | Gets the list of noaa buoy ids from external api. Updates list in a local file.

#### Commands:
Name                    | Description
------------------------|---------------------------------------------------------------------------------
updateBuoys             | Checks if there are changes to the NOAA buoy identifiers and stores in a local file.

#### Testing
Unit and feature tests are included and live in the `tests/` folder.
PHPUnit, which is included with Laravel, can be used for testing.
```
$ vendor/bin/phpunit tests/
```
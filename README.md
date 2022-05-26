# Airline Flights

This application allow to display flights list.

## Installation

```
git clone https://github.com/buba71/airline_flights.git

cd airline_flights

composer install

yarn run dev
````

## Create Database

````
symfony console doctrine:database:create

symfony console doctrine:schema: update --force

````

## Create admin account

Create admin user by running this symfony command.

````
symfony console app:create:admin email password 

````
Replace "email" by your email and password by your password.

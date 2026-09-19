#!/bin/bash


# Copy the .env.example file to .env
cp .env.example .env

sudo chmod -R 777 ./
sudo rm -R storage/debugbar
sudo rm -R storage/logs


# Run composer update to install or update dependencies
composer update


# Clear the application cache
php artisan optimize:clear



# Run database migrations and seed the database
php artisan migrate:fresh --seed

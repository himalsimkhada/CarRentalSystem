#!/bin/bash

echo "Only run this script once at the time of installation"

PACKAGES="php-cli php-pcov php-mysql php-curl composer phpunit"
CONFIG_FILE=.env

#Set configs
export DB_CONNECTION=mysql
export DB_HOST=127.0.0.1
export DB_PORT=3306
export DB_DATABASE=carrental
export DB_USERNAME=root
export DB_PASSWORD=3Xtenso@123

echo "Installing required packages."
sudo apt update
sudo apt install ${PACKAGES}

if [ ! -f ${CONFIG_FILE} ]; then
    echo "${CONFIG_FILE} doesnt exists"
    echo "Making a ${CONFIG_FILE} with reference with .env.example"
    cp ./.env.example ./.env
fi

composer update

php artisan migrate
php artisan db:seed --class=DefaultCredentials
php artisan serve

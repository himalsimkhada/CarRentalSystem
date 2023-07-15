#!/bin/bash

export DB_CONNECTION=mysql
export DB_HOST=127.0.0.1
export DB_PORT=3306
export DB_DATABASE=carrental
export DB_USERNAME=root
export DB_PASSWORD=3Xtenso@123

php artisan serve

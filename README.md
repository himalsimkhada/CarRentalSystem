# CarRental System (Online) -- LARAVEL

Online Car Rental System is written in PHP but uses Laravel framework. It utilizes most of the laravel framework and also includes additional external packages.

## Requirements

    1. PHP 7.3
    2. Composer
    3. MySQL
    4. Laravel

## Packages

    1. PCOV

## Steps to install

This guide uses Centos 7. Please use your prefered search engine on other OS guides.

    1. Please install PHP 7.3 on your machine.
        $ php -v

    2. Install PHP PCOV Package
        $ pecl install pcov

    3. Install composer using PHP

    4. After installing composer go into the project directory
        $ cd <project-directory>

    5. Run composer update
        $ composer update

    6. After composer update command is successfull run database migration command
        $ php artisan migrate

    7. If you want default configuration please seed the database using below command.
        $ php artisan db:seed --class=DefaultCredentials

        Note:   This seed some default configuration into the database like default users and some other things. 
            (Credentials are provided below)

    8. Now we can serve our webpage please use below command to serve the webpage.
        $ php artisan serve

    OR
        $ php artisan serve --host=XXX.XXX.XXX.XXX --port=XXXX

    9. Please use `http://<host>:<port>` in your browser for visiting webpage.
        Default address: `http://localhost:8000`
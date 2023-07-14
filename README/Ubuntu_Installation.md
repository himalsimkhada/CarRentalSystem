# Installation -> Ubuntu

This README file contains the procedure to run this application in Ubuntu.
> Currently Tested Ubuntu Version : 23.04

## Requirements

- Ubuntu 23.04
- PHP 8.1
- Composer
- PHP Curl Extension
- PHP PCOV Extension
- PHP MySQL Driver
- PHPUnit

## Installation

> **NOTE:** Ubuntu is required for below processes.

1. Install PHP 8.1

    ```shell
    sudo apt install php8.1-cli
    ```

2. After installing PHP 8.1, it is always good to check version. Also installing all the php extensions and drivers are required.

    ```shell
    php -v
    sudo apt install php-curl
    sudo apt install php-pcov
    sudo apt install php-mysql
    ```

3. Install composer.

    ```shell
    sudo apt install composer
    ```

4. Install PHPUnit

    ```shell
    sudo apt install phpunit
    ```


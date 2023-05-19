#!/bin/bash

sudo apt update

sudo apt install -y mysql-server

sudo add-apt-repository ppa:ondrej/php -y

sudo apt install php8.1 -y

sudo apt install php8.1-mysql -y

sudo apt-get install php8.1-xml -y

sudo apt install php8.1-mbstring -y

sudo apt install php8.1-pdo -y

sudo apt install curl -y

sudo apt-get install php8.1-curl -y

sudo apt install php8.1-cli unzip -y

curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php

sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

cd /var/www/html

composer update

sudo cp -rf /var/www/html/000-default.conf /etc/apache2/sites-available/000-default.conf

sudo a2enmod rewrite

sudo cp -rf /var/www/html/php.ini /etc/php/8.1/cli/

sudo cp -rf /var/www/html/hosts /etc/

php artisan storage:link

# sudo apt install ttf-mscorefonts-installer -y

sudo a2enmod ssl

sudo systemctl restart apache2.service
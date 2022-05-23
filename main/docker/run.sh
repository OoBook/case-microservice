#!/bin/sh

cd /var/www/html

# php artisan test
[ -d storage/mongodb ] || mkdir storage/mongodb
[ -d storage/dbdata ] || mkdir storage/dbdata
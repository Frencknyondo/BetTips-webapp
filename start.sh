#!/bin/bash

php artisan key:generate --no-interaction
php artisan migrate --force --no-interaction
rm -rf public/storage
php artisan storage:link

php artisan serve --host=0.0.0.0 --port=$PORT

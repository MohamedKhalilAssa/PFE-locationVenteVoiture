#!/bin/sh
git pull
composer install --working-dir ./back-end/
php ./back-end/artisan migrate:fresh --seed
npm install --prefix ./front-end-vue/

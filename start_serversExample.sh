#!/bin/bash

front_end_path="/home/ylamalem/Bureau/docker project/t/PFE-locationVenteVoiture/front-end-vue"
back_end_path="/home/ylamalem/Bureau/docker project/t/PFE-locationVenteVoiture/back-end"
server_ip="IP"

gnome-terminal --working-directory="$front_end_path" -- npm run serve

gnome-terminal --tab --working-directory="$front_end_path" -- npm run watch

gnome-terminal --tab --working-directory="$back_end_path" -- php artisan serve --host=$server_ip

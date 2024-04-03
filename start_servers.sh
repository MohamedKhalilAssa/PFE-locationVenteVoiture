#!/bin/bash

front_end_path="/home/mohamedkhalil/web/PFE-locationVenteVoiture/front-end-vue"
back_end_path="/home/mohamedkhalil/web/PFE-locationVenteVoiture/back-end"
caacs

gnome-terminal --working-directory="$front_end_path" -- npm run serve

gnome-terminal --tab --working-directory="$front_end_path" -- npm run watch

gnome-terminal --tab --working-directory="$back_end_path" -- php artisan serve

#!/bin/bash

front_end_path="path/to/front-end"
back_end_path="path/to/front-end"


gnome-terminal --working-directory="$front_end_path" -- npm run serve

gnome-terminal --tab --working-directory="$front_end_path" -- npm run watch

gnome-terminal --tab --working-directory="$back_end_path" -- php artisan serve

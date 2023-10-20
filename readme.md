# Geovisit

## Informations sur le projet

- Laravel 8
- PHP 7.4

## Installation

- ```git clone https://gitlab.dsi.uca.fr/lylblaud/geovisit```
- ```cd geovisit/```
- Créer un fichier .env
- ```composer install```
- ```mkdir -p storage/framework/{sessions,views,cache}```
- Permissions sur le dossier avec CHMOD
- ```php artisan cache:clear```
- ```php artisan config:clear```
- ```php artisan view:clear```
- ```php artisan migrate:refresh```
- ```php artisan db:seed```
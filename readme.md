Geovisit
========


Pre-requires
------------

- PHP 8.1
- Composer >= 2.4.4
- MariaDB >= 10.6
- HTTP server : Nginx/Apache

Installation
------------

- ```git clone ```[https://github.com/UCA-Squad/Geovisit](https://github.com/UCA-Squad/Geovisit)
- ```cd geovisit/```
- ```cp .env .env.local```

Change variables in .env.local.


- ```composer install```
- ```mkdir -p storage/framework/{sessions,views,cache}```

You may be forced to allow your apache/nginx to write in these directories. It Depends on your system settings

- ```php artisan cache:clear```
- ```php artisan config:clear```
- ```php artisan view:clear```
- ```php artisan migrate:refresh```
- ```php artisan db:seed```
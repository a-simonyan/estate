<!-- ubuntu  -->
sudo apt install php php-pgsql libapache2-mod-php

<!-- set database and email settings in .env file -->
<!-- run this artisan commands -->
php artisan migrate
php artisan db:seed
php artisan key:generate 
php artisan passport:install
<!--add in .env
PASSPORT_CLIENT_ID=2
PASSPORT_CLIENT_SECRET= ...-->
php artisan config:clear
php artisan storage:link
php artisan serve

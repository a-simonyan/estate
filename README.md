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
php artisan queue:work
<!-- php artisan schedule:run -->
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

<!-- resize images -->
<!-- composer require intervention/image -->
<!-- https://hackthestuff.com/article/how-to-resize-and-upload-images-in-laravel-8-using-intervention-image -->
<!--Error:  GD Library extension not available with this PHP installation -->
sudo apt-get install php-gd


<!-- redis socket-->
<!-- https://www.itsolutionstuff.com/post/real-time-event-broadcasting-with-laravel-6-and-socketioexample.html -->
<!-- composer require predis/predis -->
<!-- npm install -g laravel-echo-server -->
<!-- laravel-echo-server init -->
<!-- sudo apt install redis-server -->
<!-- laravel-echo-server start -->


<!-- php artisan schedule:run
You can schedule it writing your command using the crontab editor:
crontab -e
To see your scheduled commands run:
crontab -l -->
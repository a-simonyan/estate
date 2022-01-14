#!/bin/sh
cd /var/www/html
git clean -f
git checkout -- $(git ls-files -m)
git pull "https://arnologyllc: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@github.com/arnologyllc/estate.git" master
yes | composer install
php artisan migrate
php artisan config:clear

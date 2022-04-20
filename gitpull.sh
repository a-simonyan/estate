#!/bin/sh
cd /var/www/html
git clean -f
git checkout -- $(git ls-files -m)
git pull "https://arnologyllc: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@github.com/arnologyllc/estate.git" devmaster
yes | composer install
php artisan migrate
php artisan config:clear

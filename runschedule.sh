#!usr/bin/bash

cd /var/www
su www -c "/usr/local/bin/php artisan schedule:run"
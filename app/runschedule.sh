#! usr/bin/bash

#/usr/local/bin/php /var/www/artisan schedule:run
cd /var/www
su www -c "/usr/local/bin/php artisan schedule:run"

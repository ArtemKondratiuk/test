Getting started

git clone https://github.com/ArtemKondratiuk/test.git

cd test

docker-compose up -d

docker exec -it php-fpm bash

composer install

bin/console doctrine:migration:migrate

bin/console doctrine:fixtures:load

go to http://localhost/api

Credantion for admin
email: admin@gmail.com
password: 12345678

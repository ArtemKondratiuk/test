Getting started

git https://github.com/ArtemKondratiuk/test.git

cd test

docker-compose up -d

composer install

docker exec -it php-fpm bash

bin/console doctrine:migration:migrate

go to http://localhost/api


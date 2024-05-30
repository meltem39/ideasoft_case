change env.example => env

composer i

/***********************/

docker-compose down

docker-compose up -d --build

docker-compose exec db mysql -u root -p

CREATE DATABASE meltem_ideasoft;

/*********************/

php artisan key:generate

php artisan migrate

php artisan db:seed

php artisan passport:install

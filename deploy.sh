rsync -acvz --delete / root@160.251.21.51
ssh root@160.251.21.51 "yarn install; cp .env.example .env; php artisan key:generate; yarn docker; yarn migrate; yarn docker-bash; composer install; exit; yarn hot"

rsync -acvz --delete ./ karayuu@118.27.6.30:~/dev --exclude 'node_modules' --exclude 'vendor' --exclude '.git' --exclude '.husky' --exclude 'docker_dev/data' --exclude 'docker_deploy/data' --exclude 'storage'
ssh karayuu@118.27.6.30 "cd ~/dev; yarn install;
 export MYSQL_ROOT_PASSWORD=$1;
 cd docker_deploy && docker-compose up -d --build;
 docker-compose exec -T web composer install;
 cd ..; cp .env.example .env;
 sed -i -e \"s/DB_PASSWORD=default/DB_PASSWORD=$1\" .env;
 cd docker_deploy && docker-compose exec -T web php artisan key:generate;
 docker-compose run web php artisan migrate;
 yarn dev"


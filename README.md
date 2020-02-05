# tutorial
## Install Docker
```https://docs.docker.com/install/```

## Checkout code
```git clone ... ```

## Build and run
```docker-compose build --force-rm && docker-compose up -d --force-recreate```

## Database
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
update .env
php bin/console doctrine:database:create
php bin/console d:m:migrate -n

localhost:80
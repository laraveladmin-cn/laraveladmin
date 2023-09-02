docker compose exec php envoy run update --branch=master
docker compose run --rm node npm run prod && \
docker compose exec php php artisan build:index.html

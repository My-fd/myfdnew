start:
	service nginx stop || true
	service apache2 stop || true
	service mysql stop || true
	service redis-server stop || true
	docker compose up --remove-orphans -d
stop:
	docker compose stop
update: start
	docker compose exec fd-app composer install
	docker compose exec fd-app php artisan migrate
	docker compose exec fd-app php artisan storage:link
run: update
	# Консольные команды
	cp .env.local .env

# Обработчики очередей
	docker compose exec -d fd-app php artisan queue:work
test:
	docker compose exec fd-app php artisan migrate --env=testing
	docker compose exec fd-app php artisan test

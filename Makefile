start:
	sudo service nginx stop || true
	sudo service apache2 stop || true
	sudo service mysql stop || true
	sudo service redis-server stop || true
	sudo docker compose up --remove-orphans -d
stop:
	sudo docker compose stop
update: start
	sudo docker compose exec bb-app composer install
	sudo docker compose exec bb-app php artisan migrate
	sudo docker compose exec bb-app php artisan storage:link
create-indexes:
	# Создаём полнотекстовые индексы для моделей
	sudo docker compose exec bb-app php artisan scout:mysql-index App\\Models\\Post
	sudo docker compose exec bb-app php artisan scout:mysql-index App\\Models\\HelpArticle
	sudo docker compose exec bb-app php artisan scout:mysql-index App\\Models\\FAQ\\Faq
drop-indexes:
	# Удаляем полнотекстовые индексы у моделей
	sudo docker compose exec bb-app php artisan scout:mysql-index App\\Models\\Post --drop
	sudo docker compose exec bb-app php artisan scout:mysql-index App\\Models\\HelpArticle --drop
	sudo docker compose exec bb-app php artisan scout:mysql-index App\\Models\\FAQ\\Faq --drop
run: update create-indexes
	# Консольные команды
	sudo docker compose exec -d bb-app php artisan env:sync
	sudo docker compose exec -d bb-app php artisan amo:token-refresh
	sudo docker compose exec -d bb-app php artisan changed-balance:email
	sudo docker compose exec -d bb-app php artisan order:status

# Обработчики очередей
	sudo docker compose exec -d bb-app php artisan queue:work
test:
	sudo docker compose exec bb-app php artisan migrate --env=testing
	sudo docker compose exec bb-app php artisan test

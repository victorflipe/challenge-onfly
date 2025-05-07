# Nome dos containers
BACKEND_CONTAINER=laravel-app
FRONTEND_CONTAINER=vue-app

# Sobe os containers com build
up:
	docker-compose up -d --build

# Derruba os containers
down:
	docker-compose down

# Acessa o bash do backend (Laravel)
bash:
	docker exec -it $(BACKEND_CONTAINER) bash

# Logs em tempo real
logs:
	docker-compose logs -f

# Instala dependências
install-backend:
	docker exec -it $(BACKEND_CONTAINER) composer install

create-env:
	docker exec -it $(BACKEND_CONTAINER) sh -c 'if [ ! -f .env ]; then cp .env.example .env; fi'

# Laravel Artisan
key:
	docker exec -it $(BACKEND_CONTAINER) php artisan key:generate

migrate:
	docker exec -it $(BACKEND_CONTAINER) php artisan migrate

fresh:
	docker exec -it $(BACKEND_CONTAINER) php artisan migrate:fresh

seed:
	docker exec -it $(BACKEND_CONTAINER) php artisan db:seed

# Artisan Cache/Clear
cache:
	docker exec -it $(BACKEND_CONTAINER) php artisan config:cache \
		&& docker exec -it $(BACKEND_CONTAINER) php artisan route:cache \
		&& docker exec -it $(BACKEND_CONTAINER) php artisan view:cache

clear:
	docker exec -it $(BACKEND_CONTAINER) php artisan config:clear \
		&& docker exec -it $(BACKEND_CONTAINER) php artisan route:clear \
		&& docker exec -it $(BACKEND_CONTAINER) php artisan view:clear

# Cria novas migrations e seeders
make-migration:
	docker exec -it $(BACKEND_CONTAINER) php artisan make:migration $(name)

make-seeder:
	docker exec -it $(BACKEND_CONTAINER) php artisan make:seeder $(name)

# Executa testes do Laravel
test:
	docker exec -it $(BACKEND_CONTAINER) sh -c '\
		[ -f .env.testing ] || cp .env.testing.example .env.testing; \
		if ! grep -q "^APP_KEY=" .env.testing; then \
			php artisan key:generate --env=testing; \
		fi; \
		php artisan config:clear; \
		php artisan config:cache; \
		php artisan test --testsuite=Feature --env=testing'


# Comando completo para inicializar tudo
init: up install-backend create-env key fresh seed

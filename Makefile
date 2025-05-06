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

install-frontend:
	docker exec -it $(FRONTEND_CONTAINER) npm install

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
	docker exec -it $(BACKEND_CONTAINER) php artisan test

# Comando para verificar se .env existe e copiar do .env.example
check-env:
	@if [ ! -f .env ]; then cp .env.example .env; echo ".env não encontrado, copiado de .env.example"; fi

# Comando completo para inicializar tudo
init: up install-backend key migrate install-frontend

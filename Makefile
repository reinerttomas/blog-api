web=blog-api-web-1
php=blog-api-php-1

### DOCKER ###

build:
	@docker compose build

up:
	@docker compose up -d

down:
	@docker compose down

clean:
	@docker system prune --all --force

php:
	@docker exec -it $(php) sh

logs-php:
	@docker logs -f $(php)

web:
	@docker exec -it $(web) sh

logs-web:
	@docker logs -f $(web)

start:
	php artisan serve

setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	npm install

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f --lines=100 storage/logs/laravel.log

test:
	php artisan test

deploy:
	git push heroku

lint:
	composer phpcs

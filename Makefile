run:
	php artisan serve
test:
	vendor/bin/phpunit
lint:
	composer run-script phpcs routes/web.php -- --standard=PSR12
install:
	composer install
run:
	php -S localhost:8000 -t public/
test:
	vendor/bin/phpunit
lint:
	composer run-script phpcs routes/web.php -- --standard=PSR12
install:
	composer install
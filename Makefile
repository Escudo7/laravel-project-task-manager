run:
	php -S localhost:8000 -t public/
test:
	composer run-script phpunit
lint:
	composer run-script phpcs routes/web.php tests/Feature app/Http/Controllers -- --standard=PSR12
install:
	composer install
install:
	composer install

autoload:
	composer dump-autoload

test:
	composer exec phpunit
	composer exec test-reporter

lint:
	composer exec 'phpcs --standard=PSR2 src'

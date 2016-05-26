install:
	composer install

autoload:
	composer dump-autoload

test:
	composer exec phpunit --coverage-clover build/logs/clover.xml
	composer exec test-reporter

lint:
	composer exec 'phpcs --standard=PSR2 src'

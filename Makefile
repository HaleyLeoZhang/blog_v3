default: ini

ini:
	@echo "Initial php project..."
	@wget https://getcomposer.org/download/1.9.3/composer.phar
	@echo "Downloading composer.phar v1.9.3 for current project"
	@make php
	@echo "Initial php project done"

php:
	@php composer.phar  install --no-scripts -vvv
	@php artisan rsa_file

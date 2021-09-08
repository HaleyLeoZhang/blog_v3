default: ini

ini:
	@clear
	@echo "Initial php project..."
	@make composer
	@make php
	@echo "Initial php project done"

composer:
	@make composer_install
	@make composer_mv

composer_install:
	@wget https://getcomposer.org/download/1.9.3/composer.phar

composer_mv:
	@chmod 755 ./composer.phar
	@mv ./composer.phar /usr/local/bin/composer
	@composer config repo.packagist composer https://packagist.phpcomposer.com
	@echo "Downloading composer.phar v1.9.3 for current project"

php:
	@composer  install --no-scripts -vvv
	@php artisan rsa_file

PHPUNIT_BIN = ./vendor/bin/phpunit
PHPCS_BIN = ./vendor/bin/phpcs
PHPSTAN_BIN = ./vendor/bin/phpstan
PHPMD_BIN = ./vendor/bin/phpmd
PHP_CS_FIXER=./vendor/bin/php-cs-fixer
SOURCE_FOLDERS = src

.PHONY: test fix analysis

analysis:
	php -l .
	$(PHPCS_BIN) --standard=PSR2 $(SOURCE_FOLDERS)
	$(PHPSTAN_BIN) analyse $(SOURCE_FOLDERS) --level=7
	$(foreach FOLDER, $(SOURCE_FOLDERS), $(shell $(PHPMD_BIN) $(FOLDER) text cleancode,codesize,controversial,design,naming,unusedcode))

fix:
	$(PHP_CS_FIXER) fix $(SOURCE_FOLDERS)

test:
	$(PHPUNIT_BIN)

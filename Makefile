cs:
	vendor/bin/php-cs-fixer --verbose fix --config=.php_cs.dist

cs_dry_run:
	vendor/bin/php-cs-fixer --verbose fix --config=.php_cs.dist --dry-run

stan:
	vendor/bin/phpstan analyse

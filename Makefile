check:
	COMPOSER_MEMORY_LIMIT=-1 composer lint
	COMPOSER_MEMORY_LIMIT=-1 composer pinttest
	COMPOSER_MEMORY_LIMIT=-1 composer phpstan
fix:
	COMPOSER_MEMORY_LIMIT=-1 composer pint
analyze:
	COMPOSER_MEMORY_LIMIT=-1 composer phpstan
test:
	COMPOSER_MEMORY_LIMIT=-1 composer test
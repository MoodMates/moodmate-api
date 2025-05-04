start:
	./vendor/bin/sail up

stop:
	./vendor/bin/sail down

migrate:
	./vendor/bin/sail artisan migrate

test:
	docker exec -t moodmate-api-laravel.test-1 ./vendor/bin/pest

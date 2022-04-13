build:
	docker-compose -p alertcoingecko_4 -f docker/docker-compose.yaml build --no-cache

startup:
	docker-compose -p alertcoingecko_4 -f docker/docker-compose.yaml up -d

stop:
	docker-compose -p alertcoingecko_4 -f docker/docker-compose.yaml down --remove-orphans

composer_install:
	docker-compose -p alertcoingecko_4 -f docker/docker-compose.yaml run php-cli composer update

install: build composer_install

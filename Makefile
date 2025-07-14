.PHONY: *

IMAGE = roadsurfer-php-test
DOCKER = docker run --rm -it -v   "$(PWD)":/app

build:
	docker build -t $(IMAGE) docker/.

install:
	$(DOCKER) $(IMAGE) composer install

start-web:
	$(DOCKER) -p '8080:80' $(IMAGE) php -S 0.0.0.0:80 public

sh:
	$(DOCKER) $(IMAGE) sh

test:
	$(DOCKER) $(IMAGE) composer test

test-coverage:
	$(DOCKER) $(IMAGE) composer test:coverage

format:
	$(DOCKER) $(IMAGE) composer format

phpstan:
	$(DOCKER) $(IMAGE) composer phpstan

pre-commit:
	$(DOCKER) $(IMAGE) composer pre-commit
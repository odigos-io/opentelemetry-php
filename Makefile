PHP_OTEL_VERSION=1.1.2
PHP_VERSIONS=8.0 8.1 8.2 8.3 8.4
DOCKER_MOUNT_NAME=php-otel-ext-out

# Helper method to switch PHP version during development
.PHONY: switch-php/%
switch-php/%:
	@for v in $(PHP_VERSIONS); do \
		brew unlink php@$$v || true; \
	done
	@if [ "$*" = "8.0" ]; then \
		brew install shivammathur/php/php@8.0; \
	else \
		brew install php@$* || true; \
	fi
	@brew link --overwrite --force php@$*

# Main method to build the binaries
.PHONY: all
all:
	@for v in $(PHP_VERSIONS); do \
		$(MAKE) -j $(nproc) binaries/$$v; \
	done

delete-files/%:
	@rm -rf ./$*/vendor
	@rm -rf ./$*/composer.lock
	@rm -rf ./$*/opentelemetry.so
	@rm -rf ./$*/opentelemetry.ini

copy-files-from-container/%:
	@docker cp ${DOCKER_MOUNT_NAME}-$*:/$*/vendor ./$*/vendor
	@docker cp ${DOCKER_MOUNT_NAME}-$*:/$*/composer.lock ./$*/composer.lock
	@docker cp ${DOCKER_MOUNT_NAME}-$*:/$*/opentelemetry.so ./$*/opentelemetry.so
	@docker cp ${DOCKER_MOUNT_NAME}-$*:/$*/opentelemetry.ini ./$*/opentelemetry.ini

build-image/%:
	@docker build --target output -t ${DOCKER_MOUNT_NAME}:$* -f Dockerfile \
		--build-arg PHP_OTEL_VERSION=$(PHP_OTEL_VERSION) \
		--build-arg PHP_VERSION=$* .

mount-container/%:
	@docker create --name ${DOCKER_MOUNT_NAME}-$* ${DOCKER_MOUNT_NAME}:$*

unmount-container/%:
	@docker rm ${DOCKER_MOUNT_NAME}-$*

binaries/%:
	$(MAKE) delete-files/$*
	$(MAKE) build-image/$*
	$(MAKE) mount-container/$*
	$(MAKE) copy-files-from-container/$*
	$(MAKE) unmount-container/$*

# bake:
# 	@docker buildx bake --file docker-bake.hcl \
# 		--set *.args.PHP_OTEL_VERSION=$(PHP_OTEL_VERSION) \
# 		--set php-base.args.PHP_VERSION=$(PHP_VERSION)bake

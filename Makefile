PHP_OTEL_VERSION=1.1.2
PHP_VERSIONS=8.0 8.1 8.2 8.3 8.4
DOCKER_MOUNT_NAME=php-otel-ext-out

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

install-ext:
	@pecl install opentelemetry
	@echo "extension=opentelemetry.so" > $(php --ini | grep "Scan for additional .ini files in:" | sed 's/^.*: //')/opentelemetry.ini


.PHONY: all
all:
	@$(MAKE) -j $(nproc) binaries
	@$(MAKE) -j $(nproc) libraries


delete-ext-files:
	@for v in $(PHP_VERSIONS); do \
    rm -rf ./$$v/opentelemetry.so; \
    rm -rf ./$$v/opentelemetry.ini; \
	done

copy-ext-files:
	@for v in $(PHP_VERSIONS); do \
		docker cp ${DOCKER_MOUNT_NAME}-$$v:/$$v/opentelemetry.so ./$$v/opentelemetry.so; \
		docker cp ${DOCKER_MOUNT_NAME}-$$v:/$$v/opentelemetry.ini ./$$v/opentelemetry.ini; \
	done

build-images:
	@for v in $(PHP_VERSIONS); do \
		docker build --target output -t ${DOCKER_MOUNT_NAME}:$$v -f Dockerfile \
		--build-arg PHP_OTEL_VERSION=$(PHP_OTEL_VERSION) \
		--build-arg PHP_VERSION=$$v .; \
	done

mount-containers:
	@for v in $(PHP_VERSIONS); do \
		docker create --name ${DOCKER_MOUNT_NAME}-$$v ${DOCKER_MOUNT_NAME}:$$v; \
	done

unmount-containers:
	@for v in $(PHP_VERSIONS); do \
		docker rm ${DOCKER_MOUNT_NAME}-$$v; \
	done

.PHONY: binaries
binaries:
	@$(MAKE) delete-ext-files
	@$(MAKE) build-images
	@$(MAKE) mount-containers
	@$(MAKE) copy-ext-files
	@$(MAKE) unmount-containers


delete-comp-files:
	@for v in $(PHP_VERSIONS); do \
    rm -rf ./$$v/vendor; \
		rm -rf ./$$v/composer.lock; \
	done

.PHONY: libraries
libraries:
	@$(MAKE) delete-comp-files
	@for v in $(PHP_VERSIONS); do \
    $(MAKE) switch-php/$$v; \
		$(MAKE) install-ext; \
		cd $(PWD)/$$v; \
		composer install --no-dev --optimize-autoloader; \
		cd ..; \
	done

# If needed, add the following flag to `composer install`:
# --ignore-platform-reqs
# This flag is used to ignore platform requirements, which can be useful if you are using a different PHP version than the one specified in the `composer.json` file. However, it is generally not recommended to use this flag unless you know what you are doing, as it can lead to compatibility issues.
# It is better to use the correct PHP version specified in the `composer.json` file to ensure that your dependencies are compatible with your project.

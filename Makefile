PHP_OTEL_VERSION=1.1.2
PHP_VERSIONS=8.0 8.1 8.2 8.3 8.4
ARCHES=arm64 amd64
DOCKER_MOUNT_NAME=otel-php

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
	@$(MAKE) bake-images
	@set -e; for vers in $(PHP_VERSIONS); do \
		$(MAKE) install-libs/$$vers; \
		for arch in $(ARCHES); do \
			($(MAKE) unmount-container/$$vers-$$arch || true); \
			$(MAKE) delete-files/$$vers-$$arch; \
			$(MAKE) mount-container/$$vers-$$arch; \
			$(MAKE) copy-files/$$vers-$$arch; \
			($(MAKE) unmount-container/$$vers-$$arch || true); \
		done; \
	done
	@echo "✅ All binaries have been built and copied to the respective directories."


install-libs/%:
	@$(MAKE) switch-php/$*
	@cd ./$*/ \
		&& composer install \
			--optimize-autoloader \
			--no-dev \
			--no-plugins \
			--ignore-platform-req=ext-amqp \
			--ignore-platform-req=ext-rdkafka \
			--ignore-platform-req=ext-mongodb \
			--ignore-platform-req=ext-mysqli \
			--ignore-platform-req=ext-intl \
			--ignore-platform-req=ext-opentelemetry

bake-images:
	@docker buildx bake --file docker-bake.hcl \
		--set *.args.PHP_OTEL_VERSION=$(PHP_OTEL_VERSION)

mount-container/%:
	@docker create --name ${DOCKER_MOUNT_NAME}-$* ${DOCKER_MOUNT_NAME}:$*

unmount-container/%:
	@docker rm ${DOCKER_MOUNT_NAME}-$*

copy-files/%:
	VERS=$$(echo "$*" | cut -d '-' -f 1); \
	ARCH=$$(echo "$*" | cut -d '-' -f 2); \
	mkdir -p ./$$VERS/$$ARCH; \
	docker cp ${DOCKER_MOUNT_NAME}-$*:/$${VERS}/opentelemetry.ini ./$${VERS}/opentelemetry.ini; \
	docker cp ${DOCKER_MOUNT_NAME}-$*:/$${VERS}/opentelemetry.so ./$${VERS}/$${ARCH}/opentelemetry.so

delete-files/%:
	VERS=$$(echo "$*" | cut -d '-' -f 1); \
	ARCH=$$(echo "$*" | cut -d '-' -f 2); \
	rm -rf ./$${VERS}/$${ARCH}

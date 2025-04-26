PHP_OTEL_VERSION=1.1.2
PHP_VERSIONS=8.0 8.1 8.2 8.3 8.4
ARCHES=arm64 amd64
DOCKER_MOUNT_NAME=otel-php

##################################################
# Main method to build the binaries
##################################################

.PHONY: all
all:
	@$(MAKE) prepare-multiarch
	@$(MAKE) bake-images
	@for vers in $(PHP_VERSIONS); do \
		for arch in $(ARCHES); do \
			echo "\n🚀 Handling binaries for PHP $$vers on $$arch"; \
			($(MAKE) unmount-container/$$vers-$$arch || true); \
			$(MAKE) mount-container/$$vers-$$arch; \
			$(MAKE) copy-files/$$vers-$$arch; \
			$(MAKE) unmount-container/$$vers-$$arch; \
		done; \
	done
	@$(MAKE) cleanup
	@echo "\n✅ All binaries have been built and copied to the respective directories."
	@for vers in $(PHP_VERSIONS); do \
		for arch in $(ARCHES); do \
			echo "👀 Checking output for $$vers $$arch"; \
			file ./$$vers/bin/$$arch/opentelemetry.so; \
		done; \
	done

prepare-multiarch:
	@echo "\n🚀 Bootstraping buildx with QEMU support"
	@docker buildx create --name multiarch --driver docker-container --use || true
	@docker buildx inspect --bootstrap

bake-images:
	@echo "\n🚀 Building images"
	@mkdir -p tmp
	@docker buildx bake --file docker-bake.hcl \
		--set *.args.PHP_OTEL_VERSION=$(PHP_OTEL_VERSION)

mount-container/%:
	@echo "🧪 Mounting container"
	@{ \
		VERS=$$(echo "$*" | cut -d '-' -f 1); \
		ARCH=$$(echo "$*" | cut -d '-' -f 2); \
		docker load -i tmp/${DOCKER_MOUNT_NAME}-$*.tar; \
		docker create --platform=linux/$${ARCH} --name ${DOCKER_MOUNT_NAME}-$* ${DOCKER_MOUNT_NAME}:$*; \
	}

unmount-container/%:
	@echo "🧪 Unmounting container"
	@docker rm ${DOCKER_MOUNT_NAME}-$*

copy-files/%:
	@echo "🧪 Copying files"
	@{ \
		VERS=$$(echo "$*" | cut -d '-' -f 1); \
		ARCH=$$(echo "$*" | cut -d '-' -f 2); \
		rm -rf ./$${VERS}/bin/$${ARCH}; \
		mkdir -p ./$${VERS}/bin/$${ARCH}; \
		docker cp ${DOCKER_MOUNT_NAME}-$*:/opentelemetry.so ./$${VERS}/bin/$${ARCH}/opentelemetry.so; \
		docker cp ${DOCKER_MOUNT_NAME}-$*:/opentelemetry.ini ./$${VERS}/opentelemetry.ini; \
	}

cleanup:
	@echo "\n🚀 Cleaning up leftovers"
	@rm -rf tmp
	@docker buildx use default || docker context use default
	@docker buildx rm multiarch

##################################################
# Helper methods during development
##################################################

.PHONY: switch-php/%
switch-php/%:
	@echo "\n🚀 Switching to PHP $*"
	@for v in $(PHP_VERSIONS); do \
		brew unlink php@$$v || true; \
	done
	@if [ "$*" = "8.0" ]; then \
		brew install shivammathur/php/php@8.0; \
	else \
		brew install php@$* || true; \
	fi
	@brew link --overwrite --force php@$*

.PHONY: install-libs/%
install-libs/%:
	@$(MAKE) switch-php/$*
	@cd ./$*/ \
		&& composer install \
			--optimize-autoloader \
			--no-dev \
			--no-plugins \
			--ignore-platform-req=ext-opentelemetry \
			--ignore-platform-req=ext-amqp \
			--ignore-platform-req=ext-rdkafka \
			--ignore-platform-req=ext-mongodb \
			--ignore-platform-req=ext-mysqli \
			--ignore-platform-req=ext-intl

.PHONY: update-libs/%
update-libs/%:
	@$(MAKE) switch-php/$*
	@cd ./$*/ \
		&& composer update \
			--optimize-autoloader \
			--no-dev \
			--no-plugins \
			--ignore-platform-req=ext-opentelemetry \
			--ignore-platform-req=ext-amqp \
			--ignore-platform-req=ext-rdkafka \
			--ignore-platform-req=ext-mongodb \
			--ignore-platform-req=ext-mysqli \
			--ignore-platform-req=ext-intl

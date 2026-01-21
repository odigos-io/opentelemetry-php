PHP_OTEL_VERSION=1.1.2
PHP_VERSIONS=8.1 8.2 8.3 8.4
ARCHES=arm64 amd64
DOCKER_MOUNT_NAME=otel-php

##################################################
# Composer commands (no local PHP needed)
##################################################

# Note: We use --ignore-platform-req=ext-* to skip extension checks (ext-opentelemetry, ext-mongodb)
# but we do NOT use --ignore-platform-reqs which would also skip PHP version checks.
# This ensures packages are installed for the correct PHP version.

.PHONY: install-libs
install-libs:
	@for vers in $(PHP_VERSIONS); do \
		echo "🚀 Installing libraries for PHP $$vers using Docker"; \
		docker run --rm -v $(PWD)/$$vers:/app -w /app \
			php:$$vers-cli sh -c "\
				apt-get update -qq && apt-get install -y -qq unzip > /dev/null 2>&1 && \
				curl -sS https://getcomposer.org/installer | php -- --quiet && \
				php composer.phar install --optimize-autoloader --no-dev --no-plugins --ignore-platform-req=ext-*"; \
	done
	@echo "✅ All libraries have been installed."

.PHONY: update-libs
update-libs:
	@for vers in $(PHP_VERSIONS); do \
		echo "🚀 Updating libraries for PHP $$vers using Docker"; \
		docker run --rm -v $(PWD)/$$vers:/app -w /app \
			php:$$vers-cli sh -c "\
				apt-get update -qq && apt-get install -y -qq unzip > /dev/null 2>&1 && \
				curl -sS https://getcomposer.org/installer | php -- --quiet && \
				php composer.phar update --optimize-autoloader --no-dev --no-plugins --ignore-platform-req=ext-*"; \
	done
	@echo "✅ All libraries have been updated."

##################################################
# Main method to build the binaries
##################################################

.PHONY: binaries
binaries:
	@$(MAKE) prepare-multiarch
	@$(MAKE) bake-images
	@for vers in $(PHP_VERSIONS); do \
		for arch in $(ARCHES); do \
			echo "🚀 Handling binaries for PHP $$vers on $$arch"; \
			($(MAKE) unmount-container/$$vers-$$arch || true); \
			$(MAKE) mount-container/$$vers-$$arch; \
			$(MAKE) copy-files/$$vers-$$arch; \
			$(MAKE) unmount-container/$$vers-$$arch; \
		done; \
	done
	@$(MAKE) cleanup
	@echo "✅ All binaries have been built and copied to the respective directories."
	@for vers in $(PHP_VERSIONS); do \
		for arch in $(ARCHES); do \
			echo "👀 Checking output for $$vers $$arch"; \
			file ./$$vers/bin/$$arch/opentelemetry.so; \
		done; \
	done

prepare-multiarch:
	@echo "🚀 Bootstraping buildx with QEMU support"
	@docker buildx create --name multiarch --driver docker-container --use || true
	@docker buildx inspect --bootstrap

bake-images:
	@echo "🚀 Building images"
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
	@echo "🚀 Cleaning up leftovers"
	@rm -rf tmp
	@docker buildx use default || docker context use default
	@docker buildx rm multiarch

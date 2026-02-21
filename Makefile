PHP_OTEL_VERSION=1.1.2
PHP_VERSIONS=8.1 8.2 8.3 8.4
ARCHES=arm64 amd64
DOCKER_MOUNT_NAME=otel-php

##################################################
# Full build: vendor + extension for all versions x arches
##################################################

.PHONY: all
all:
	@$(MAKE) prepare-multiarch
	@$(MAKE) bake-images
	@$(MAKE) copy-files
	@$(MAKE) check-binaries
	@$(MAKE) cleanup-multiarch

##################################################
# Internal targets
##################################################

prepare-multiarch:
	@echo "🚀 Bootstrapping buildx with QEMU support"
	@docker buildx create --name multiarch --driver docker-container --use || true
	@docker buildx inspect --bootstrap

cleanup-multiarch:
	@echo "🧹 Cleaning up"
	@rm -rf tmp
	@docker buildx use default || docker context use default
	@docker buildx rm multiarch 2>/dev/null || true

bake-images:
	@echo "🚀 Building images"
	@mkdir -p tmp
	@docker buildx bake --file docker-bake.hcl \
		--set '*.args.PHP_OTEL_VERSION=$(PHP_OTEL_VERSION)'

copy-files:
	@echo "📦 Copying files"
	@for vers in $(PHP_VERSIONS); do \
		VENDOR_DONE=0; \
		for arch in $(ARCHES); do \
			echo "📦 Extracting artifacts for PHP $$vers / $$arch"; \
			docker load -i tmp/$(DOCKER_MOUNT_NAME)-$$vers-$$arch.tar; \
			CID=$$(docker create --platform=linux/$$arch $(DOCKER_MOUNT_NAME):$$vers-$$arch true); \
			mkdir -p ./$$vers/bin/$$arch; \
			docker cp $$CID:/opentelemetry.so  ./$$vers/bin/$$arch/opentelemetry.so; \
			docker cp $$CID:/opentelemetry.ini ./$$vers/opentelemetry.ini; \
			if [ $$VENDOR_DONE -eq 0 ]; then \
				rm -rf ./$$vers/vendor; \
				docker cp $$CID:/vendor ./$$vers/vendor; \
				VENDOR_DONE=1; \
			fi; \
			docker rm $$CID > /dev/null 2>&1; \
		done; \
	done

check-binaries:
	@echo "🔍 Checking binaries"
	@for vers in $(PHP_VERSIONS); do \
		for arch in $(ARCHES); do \
			echo "👀 $$vers/bin/$$arch/opentelemetry.so"; \
			file ./$$vers/bin/$$arch/opentelemetry.so; \
		done; \
	done

##################################################
# Dev: build release image and deploy to Kind cluster
##################################################

KIND_NODE ?= kind-control-plane
ODIGLET_PHP_PATH ?= /var/odigos/php
DEV_IMAGE = php-community-dev

.PHONY: deploy-dev
deploy-dev:
	@echo "📦 Building release image..."
	@docker build -f release.Dockerfile -t $(DEV_IMAGE) .
	@echo "📤 Extracting instrumentations from image..."
	@CID=$$(docker create $(DEV_IMAGE) true); \
	docker cp $$CID:/instrumentations/php - | \
		docker exec -i $(KIND_NODE) sh -c 'rm -rf $(ODIGLET_PHP_PATH) && mkdir -p $(ODIGLET_PHP_PATH) && tar xf - -C $(ODIGLET_PHP_PATH) --strip-components=1'; \
	docker rm $$CID > /dev/null 2>&1
	@echo "✅ PHP instrumentations deployed to $(KIND_NODE):$(ODIGLET_PHP_PATH)"
	@docker exec $(KIND_NODE) ls -la $(ODIGLET_PHP_PATH)

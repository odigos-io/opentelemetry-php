PHP_OTEL_VERSION=1.1.2
PHP_VERSIONS=8.0 8.1 8.2 8.3 8.4
DOCKER_MOUNT_NAME=php-otel-ext-out

all:
	@$(MAKE) -j $(nproc) binaries

delete-files:
	@for v in $(PHP_VERSIONS); do \
    rm -rf ./$$v/opentelemetry.so; \
    rm -rf ./$$v/opentelemetry.ini; \
	done

copy-files:
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
	@$(MAKE) delete-files
	@$(MAKE) build-images
	@$(MAKE) mount-containers
	@$(MAKE) copy-files
	@$(MAKE) unmount-containers

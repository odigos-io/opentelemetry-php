FROM --platform=$BUILDPLATFORM alpine AS php-community-build
WORKDIR /opentelemetry-php
ARG TARGETARCH
ARG PHP_VERSIONS="8.1 8.2 8.3 8.4"
ENV PHP_VERSIONS=${PHP_VERSIONS}
COPY . .

# create a directory for the instrumentations and put each PHP version in it
RUN mkdir -p /instrumentations/php

# Move the pre-compiled binaries to the correct directories
RUN for v in ${PHP_VERSIONS}; do \
    mv ./$v/bin/${TARGETARCH}/* ./$v/; \
    rm -rf ./$v/bin; \
    mkdir -p /instrumentations/php/$v; \
    mv ./$v/* /instrumentations/php/$v/; \
    cp ./_helpers/odigos_autoload.php /instrumentations/php/$v/odigos_autoload.php; \
    cp ./_helpers/CustomInstrumentation.php /instrumentations/php/$v/CustomInstrumentation.php; \
    done

FROM scratch
WORKDIR /instrumentations

COPY --from=php-community-build /instrumentations .

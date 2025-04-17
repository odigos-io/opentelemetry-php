ARG PHP_VERSION
FROM --platform=$BUILDPLATFORM php:${PHP_VERSION}-cli AS builder
ARG PHP_VERSION
ARG PHP_OTEL_VERSION
WORKDIR /${PHP_VERSION}

#  Install system/docker dependencies
RUN apt-get update && apt-get upgrade -y && apt-get install -y wget unzip gcc make autoconf libicu-dev
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Install the OTel extension (see https://opentelemetry.io/docs/zero-code/php/#install-the-opentelemetry-extension)
# Note: we use GitHub for version control.
RUN wget https://github.com/open-telemetry/opentelemetry-php-instrumentation/releases/download/${PHP_OTEL_VERSION}/opentelemetry-pecl.zip \
  && unzip opentelemetry-pecl.zip && tar -xzf opentelemetry-${PHP_OTEL_VERSION}.tgz opentelemetry-${PHP_OTEL_VERSION}
# Build the OTel extension
RUN cd opentelemetry-${PHP_OTEL_VERSION} \
  && phpize && ./configure && make && make install

# Isolate the built binary
RUN mv opentelemetry-${PHP_OTEL_VERSION}/modules/opentelemetry.so opentelemetry.so \
  && rm -rf opentelemetry-${PHP_OTEL_VERSION}
# Create a pointer to the built binary
RUN echo "extension=/var/odigos/php/${PHP_VERSION}/opentelemetry.so\nauto_prepend_file=/var/odigos/php/${PHP_VERSION}/index.php" > opentelemetry.ini

# Enable the extension (for `composer install` below)
RUN cp opentelemetry.so "$(php-config --extension-dir)/opentelemetry.so" \
  && docker-php-ext-enable opentelemetry
# Install composer dependencies (just to test version compatibility)
COPY ./${PHP_VERSION} .
RUN docker-php-ext-install intl && docker-php-ext-enable intl
RUN composer install
RUN cp "$(php-config --extension-dir)/opentelemetry.so" opentelemetry.so

FROM scratch AS output
ARG PHP_VERSION
COPY --from=builder ./${PHP_VERSION} ./${PHP_VERSION}
CMD ["echo", "PHP $${PHP_VERSION} OpenTelemetry binaries created"]

ARG PHP_VERSION
FROM --platform=$BUILDPLATFORM php:${PHP_VERSION}-cli AS builder
ARG PHP_VERSION
ARG PHP_OTEL_VERSION
WORKDIR /${PHP_VERSION}

# Install system/docker dependencies
RUN apt-get update && apt-get upgrade -y \
  && apt-get install -y wget unzip gcc make autoconf libicu-dev \
  && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Install the OTel extension (see https://opentelemetry.io/docs/zero-code/php/#install-the-opentelemetry-extension)
RUN pecl install opentelemetry-${PHP_OTEL_VERSION} \
  && docker-php-ext-enable opentelemetry

# Isolate the binary & create a pointer
RUN cp "$(php-config --extension-dir)/opentelemetry.so" opentelemetry.so
RUN echo "extension=/var/odigos/php/${PHP_VERSION}/opentelemetry.so\nauto_prepend_file=/var/odigos/php/${PHP_VERSION}/index.php" > opentelemetry.ini

# Enable extensions (for 'composer install' below)
RUN cp opentelemetry.so "$(php-config --extension-dir)/opentelemetry.so" \
  && docker-php-ext-enable opentelemetry
# Install composer libraries
COPY ./${PHP_VERSION}/composer.json .
RUN composer config --no-plugins allow-plugins.yiisoft/yii2-composer true \
  && composer install --no-dev --optimize-autoloader --ignore-platform-reqs

FROM scratch AS output
ARG PHP_VERSION
COPY --from=builder ./${PHP_VERSION} ./${PHP_VERSION}
CMD ["ls", "-al", "./${PHP_VERSION}"]

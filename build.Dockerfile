# ---------------------------------------------------------------------------
# Stage 1 — extension: compile opentelemetry.so for the target PHP version
# Uses the real target PHP version so phpize/make produce the right binary.
# ---------------------------------------------------------------------------
ARG PHP_VERSION
FROM php:${PHP_VERSION}-cli AS extension
ARG PHP_VERSION
ARG PHP_OTEL_VERSION

RUN curl -sSL https://github.com/open-telemetry/opentelemetry-php-instrumentation/archive/refs/tags/${PHP_OTEL_VERSION}.tar.gz \
        -o tmp.tar.gz \
    && tar -xzf tmp.tar.gz \
    && rm tmp.tar.gz \
    && cd opentelemetry-php-instrumentation-${PHP_OTEL_VERSION}/ext \
    && phpize && ./configure && make && make install \
    && mv modules/opentelemetry.so /opentelemetry.so \
    && cd / && rm -rf opentelemetry-php-instrumentation-${PHP_OTEL_VERSION}

RUN cat <<EOF > /opentelemetry.ini
extension=/var/odigos/php/${PHP_VERSION}/opentelemetry.so
auto_prepend_file=/var/odigos/php/${PHP_VERSION}/vendor/autoload.php
EOF

# TODO: find a way to set the preload_user dynamically, then add to the ini file, and inject the PHP_VERSION into the preload.php file.
# opcache.preload=/var/odigos/php/${PHP_VERSION}/preload.php
# opcache.preload_user=<www-data,apache,etc...>

# ---------------------------------------------------------------------------
# Stage 2 — vendor: composer install + PHP-Scoper + classmap rebuild
# Always uses PHP 8.4 because PHP-Scoper needs 8.2+ and only processes text.
# ---------------------------------------------------------------------------
FROM php:8.4-cli AS vendor
ARG PHP_VERSION

WORKDIR /work

COPY ${PHP_VERSION}/composer.json ${PHP_VERSION}/composer.lock ./

RUN apt-get update -qq \
    && apt-get install -y -qq unzip > /dev/null 2>&1 \
    && curl -sS https://getcomposer.org/installer | php -- --quiet \
    && php composer.phar install \
        --optimize-autoloader --no-dev --no-plugins --ignore-platform-reqs \
    && rm composer.phar

RUN curl -sSL https://github.com/humbug/php-scoper/releases/latest/download/php-scoper.phar \
    -o /usr/local/bin/php-scoper.phar

COPY _helpers/scoper.inc.php _helpers/build-classmap.php /tmp/

RUN php -d memory_limit=1G /usr/local/bin/php-scoper.phar add-prefix \
        --config=/tmp/scoper.inc.php \
        --output-dir=build \
        --force --quiet \
    && cp -r vendor/composer build/composer \
    && cp vendor/autoload.php build/autoload.php \
    && rm -rf vendor \
    && mv build vendor \
    && php /tmp/build-classmap.php /work

# ---------------------------------------------------------------------------
# Stage 3 — output: minimal scratch image with just the artifacts
# ---------------------------------------------------------------------------
FROM scratch AS output
COPY --from=vendor    /work/vendor/    ./vendor/
COPY --from=extension /opentelemetry.so  ./opentelemetry.so
COPY --from=extension /opentelemetry.ini ./opentelemetry.ini

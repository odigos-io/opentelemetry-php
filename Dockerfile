ARG PHP_VERSION
FROM --platform=$TARGETPLATFORM php:${PHP_VERSION}-cli AS builder
ARG PHP_VERSION
ARG PHP_OTEL_VERSION
WORKDIR /

# Install the OTel extension (see https://opentelemetry.io/docs/zero-code/php/#install-the-opentelemetry-extension)
RUN curl -sSL https://github.com/open-telemetry/opentelemetry-php-instrumentation/archive/refs/tags/${PHP_OTEL_VERSION}.tar.gz \
  -o tmp.tar.gz \
  && tar -xzf tmp.tar.gz \
  && rm -rf tmp.tar.gz
RUN cd opentelemetry-php-instrumentation-${PHP_OTEL_VERSION}/ext \
  && phpize \
  && ./configure --enable-opentelemetry \
  && make -j"$(nproc)" \
  && make install

# Isolate the binary & create a pointer
RUN mv opentelemetry-php-instrumentation-${PHP_OTEL_VERSION}/ext/modules/opentelemetry.so opentelemetry.so
RUN echo "extension=/var/odigos/php/${PHP_VERSION}/opentelemetry.so\nauto_prepend_file=/var/odigos/php/${PHP_VERSION}/index.php" > opentelemetry.ini

# Cleanup
RUN rm -rf opentelemetry-php-instrumentation-${PHP_OTEL_VERSION}

FROM scratch AS output
COPY --from=builder . .
CMD ["ls", "-l", "."]

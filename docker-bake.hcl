group "default" {
  targets = [
    "php81-arm64", "php81-amd64",
    "php82-arm64", "php82-amd64",
    "php83-arm64", "php83-amd64",
    "php84-arm64", "php84-amd64",
  ]
}

variable "PHP_OTEL_VERSION" {
  default = "0.0.0"
}

target "php-base" {
  context    = "."
  dockerfile = "build.Dockerfile"
  target     = "output"
  args = {
    PHP_OTEL_VERSION = "${PHP_OTEL_VERSION}"
  }
}

target "php81-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.1-arm64"]
  output = ["type=oci,dest=tmp/otel-php-8.1-arm64.tar"]
  args = {
    PHP_VERSION = "8.1"
  }
}
target "php81-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.1-amd64"]
  output = ["type=oci,dest=tmp/otel-php-8.1-amd64.tar"]
  args = {
    PHP_VERSION = "8.1"
  }
}

target "php82-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.2-arm64"]
  output = ["type=oci,dest=tmp/otel-php-8.2-arm64.tar"]
  args = {
    PHP_VERSION = "8.2"
  }
}
target "php82-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.2-amd64"]
  output = ["type=oci,dest=tmp/otel-php-8.2-amd64.tar"]
  args = {
    PHP_VERSION = "8.2"
  }
}

target "php83-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.3-arm64"]
  output = ["type=oci,dest=tmp/otel-php-8.3-arm64.tar"]
  args = {
    PHP_VERSION = "8.3"
  }
}
target "php83-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.3-amd64"]
  output = ["type=oci,dest=tmp/otel-php-8.3-amd64.tar"]
  args = {
    PHP_VERSION = "8.3"
  }
}

target "php84-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.4-arm64"]
  output = ["type=oci,dest=tmp/otel-php-8.4-arm64.tar"]
  args = {
    PHP_VERSION = "8.4"
  }
}
target "php84-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.4-amd64"]
  output = ["type=oci,dest=tmp/otel-php-8.4-amd64.tar"]
  args = {
    PHP_VERSION = "8.4"
  }
}

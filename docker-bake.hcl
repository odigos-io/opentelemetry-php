group "default" {
  targets = [
    "php80-arm64", "php80-amd64",
    "php81-arm64", "php81-amd64",
    "php82-arm64", "php82-amd64",
    "php83-arm64", "php83-amd64",
    "php84-arm64", "php84-amd64",
  ]
}

variable "PHP_OTEL_VERSION" {
  default = "1.1.2"
}

target "php-base" {
  context    = "."
  dockerfile = "Dockerfile"
  target     = "output"
  platforms = [
    "linux/amd64",
    "linux/arm64"
  ]
  args = {
    PHP_OTEL_VERSION = "${PHP_OTEL_VERSION}"
  }
  build_args = {
    PHP_VERSION = "${PHP_VERSION}"
  }
}

target "php80-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.0-arm64"]
  args = {
    PHP_VERSION = "8.0"
  }
}
target "php80-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.0-amd64"]
  args = {
    PHP_VERSION = "8.0"
  }
}

target "php81-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.1-arm64"]
  args = {
    PHP_VERSION = "8.1"
  }
}
target "php81-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.1-amd64"]
  args = {
    PHP_VERSION = "8.1"
  }
}

target "php82-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.2-arm64"]
  args = {
    PHP_VERSION = "8.2"
  }
}
target "php82-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.2-amd64"]
  args = {
    PHP_VERSION = "8.2"
  }
}

target "php83-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.3-arm64"]
  args = {
    PHP_VERSION = "8.3"
  }
}
target "php83-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.3-amd64"]
  args = {
    PHP_VERSION = "8.3"
  }
}

target "php84-arm64" {
  inherits = ["php-base"]
  platforms = ["linux/arm64"]
  tags     = ["otel-php:8.4-arm64"]
  args = {
    PHP_VERSION = "8.4"
  }
}
target "php84-amd64" {
  inherits = ["php-base"]
  platforms = ["linux/amd64"]
  tags     = ["otel-php:8.4-amd64"]
  args = {
    PHP_VERSION = "8.4"
  }
}

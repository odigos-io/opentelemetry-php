group "default" {
  targets = ["php80", "php81", "php82", "php83", "php84"]
}

variable "PHP_OTEL_VERSION" {
  default = "1.1.2"
}

target "php-base" {
  context    = "."
  dockerfile = "Dockerfile"
  target     = "output"
  args = {
    PHP_OTEL_VERSION = "${PHP_OTEL_VERSION}"
  }
}

target "php80" {
  inherits = ["php-base"]
  tags     = ["php-otel-ext-out:8.0"]
  args = {
    PHP_VERSION = "8.0"
  }
}

target "php81" {
  inherits = ["php-base"]
  tags     = ["php-otel-ext-out:8.1"]
  args = {
    PHP_VERSION = "8.1"
  }
}

target "php82" {
  inherits = ["php-base"]
  tags     = ["php-otel-ext-out:8.2"]
  args = {
    PHP_VERSION = "8.2"
  }
}

target "php83" {
  inherits = ["php-base"]
  tags     = ["php-otel-ext-out:8.3"]
  args = {
    PHP_VERSION = "8.3"
  }
}

target "php84" {
  inherits = ["php-base"]
  tags     = ["php-otel-ext-out:8.4"]
  args = {
    PHP_VERSION = "8.4"
  }
}
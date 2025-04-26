# @odigos/opentelemetry-php

Odigos distribution of OpenTelemetry for PHP.<br />

Switch PHP version during development:

```bash
# PHP_VERSION is one-of: 8.0, 8.1, 8.2, 8.3, 8.4
make switch-php/{PHP_VERSION}
```

Generate binary files (opentelemetry.so) for all PHP versions:

```bash
make all
```

Note: Docker build for AMD can be a bit flaky, just re-run the make command until success.

# Deploying an agent

To deploy an agent & auto-instrument PHP with OpenTelemetry, we need a few things:

- PHP extension (`opentelemetry.so`)
- PHP libraries (`composer.json`)
- Script with exporter (`index.php`)
- Configuration file with pointers to all of the above (`opentelemetry.ini`)

**WARNING: It is important to note that the `opentelemetry.so` binaries are compiled per PHP version, which is why every PHP version has it's own agent!**

1. We need to copy the agent folder into our cluster under a pre-defined path (such as `/var/odigos/php/${PHP_VERSION}/vendor/autoload.php`), these paths are defined and must be changed accordingly in each `index.php` script.

2. We need to tell the instrumented app to load the OTel files, to do that we need to give the container an env called `OTEL_PHP_AUTOLOAD_ENABLED`, it should equal `true`.

3. We need to tell the instrumented app where to find our script and binaries, to do that we need to give the container an env called `PHP_INI_SCAN_DIR`, it should point at the dir that contains the agent files (e.g `/var/odigos/php/8.1:`).

NOTE: for step 3 we used a colon at the end of the appointed dir, that is required by the env itself, here's why:

> How to use `PHP_INI_SCAN_DIR` env with colon (:) separator:<br />
> Assuming `/php.d/\*.ini` is the dir for DEFAULT configuration files.<br />
> Assuming `/foo/bar/\*.ini` is the dir for CUSTOM configuration files.

> No colon; `PHP_INI_SCAN_DIR=/foo/bar`
>
> - will load all CUSTOM files
> - will ignore all DEFAULT files

> Colon at start; `PHP_INI_SCAN_DIR=:/foo/bar`
>
> - will 1st load all DEFAULT files
> - will 2nd load all CUSTOM files

> Colon at end; `PHP_INI_SCAN_DIR=/foo/bar:`
>
> - will 1st load all CUSTOM files
> - will 2nd load all DEFAULT files

# Library limitations

PHP 8.2 divides the required/supported libraries across PHP versions:

- ✅ Versions above 8.2 support all libraries at latest versions
- ⚠️ Versions below 8.2 have limited support (detailed below)

### All OpenTelemtry libraries at latest versions (as of April 20th 2025):

```json
{
  // OTel base
  "ext-opentelemetry": "*",
  "open-telemetry/sdk": "^1.2.4",
  "open-telemetry/exporter-otlp": "^1.2.1",
  // Libs base
  "open-telemetry/opentelemetry-auto-http-async": "^1.1.0",
  "open-telemetry/opentelemetry-auto-guzzle": "^1.1.0",
  "open-telemetry/opentelemetry-auto-psr3": "^0.0.9",
  "open-telemetry/opentelemetry-auto-psr6": "^0.0.4",
  "open-telemetry/opentelemetry-auto-psr14": "^0.0.4",
  "open-telemetry/opentelemetry-auto-psr15": "^1.1.0",
  "open-telemetry/opentelemetry-auto-psr16": "^0.0.4",
  "open-telemetry/opentelemetry-auto-psr18": "^1.1.0",
  // Libs base (supported only for 8.2+)
  "open-telemetry/opentelemetry-auto-curl": "^0.0.4",
  "open-telemetry/opentelemetry-auto-io": "^0.0.13",
  // Libs extra (frameworks)
  "open-telemetry/opentelemetry-auto-slim": "^1.1.0",
  "open-telemetry/opentelemetry-auto-codeigniter": "^0.0.9",
  "open-telemetry/opentelemetry-auto-symfony": "^1.0.0",
  "open-telemetry/opentelemetry-auto-laravel": "^1.1.1",
  "open-telemetry/opentelemetry-auto-cakephp": "^0.0.4",
  "open-telemetry/opentelemetry-auto-yii": "^0.0.6",
  "open-telemetry/opentelemetry-auto-wordpress": "^0.0.17",
  // Libs extra (communications)
  "open-telemetry/opentelemetry-auto-pdo": "^0.0.19",
  "open-telemetry/opentelemetry-auto-doctrine": "^0.1.0",
  "open-telemetry/opentelemetry-auto-mysqli": "^0.0.2",
  "open-telemetry/opentelemetry-auto-mongodb": "^0.0.8",
  "open-telemetry/opentelemetry-auto-openai-php": "^0.0.3",
  "open-telemetry/opentelemetry-auto-ext-amqp": "^0.0.5",
  "open-telemetry/opentelemetry-auto-ext-rdkafka": "^0.0.2"
}
```

### PHP 8.0 & 8.1 limitations

The following libraries are incompatible and cannot be used with versions 8.0 and 8.1:

```
open-telemetry/opentelemetry-auto-curl
open-telemetry/opentelemetry-auto-io
open-telemetry/opentelemetry-auto-pdo
open-telemetry/opentelemetry-auto-doctrine
open-telemetry/opentelemetry-auto-mysqli
open-telemetry/opentelemetry-auto-openai-php <--- is OK for 8.1
open-telemetry/opentelemetry-auto-ext-amqp
open-telemetry/opentelemetry-auto-ext-rdkafka
```

NOTE: 8.1 allows `openai-php` unlike 8.0

The rest of the libraries have reached END OF LIFE support for version 8.0 (only), and are listed here with "maxed out" versions:

```json
{
  "open-telemetry/sdk": "<=1.0.8",
  "open-telemetry/exporter-otlp": "<=1.0.4",
  "open-telemetry/opentelemetry-auto-http-async": "<=1.0.1",
  "open-telemetry/opentelemetry-auto-guzzle": "<=1.0.1",
  "open-telemetry/opentelemetry-auto-psr3": "<=0.0.8",
  "open-telemetry/opentelemetry-auto-psr6": "<=0.0.3",
  "open-telemetry/opentelemetry-auto-psr14": "<=0.0.3",
  "open-telemetry/opentelemetry-auto-psr15": "<=1.0.6",
  "open-telemetry/opentelemetry-auto-psr16": "<=0.0.3",
  "open-telemetry/opentelemetry-auto-psr18": "<=1.0.4",
  "open-telemetry/opentelemetry-auto-slim": "<=1.0.7",
  "open-telemetry/opentelemetry-auto-codeigniter": "<=0.0.8",
  "open-telemetry/opentelemetry-auto-symfony": "<=1.0.0beta30",
  "open-telemetry/opentelemetry-auto-laravel": "<=1.0.1",
  "open-telemetry/opentelemetry-auto-cakephp": "<=0.0.3",
  "open-telemetry/opentelemetry-auto-yii": "<=0.0.5",
  "open-telemetry/opentelemetry-auto-wordpress": "<=0.0.16",
  "open-telemetry/opentelemetry-auto-mongodb": "<=0.0.7"
}
```

### Toxic conflicts

These conflicts are considered "toxic" because they will crash the instrumented pods!

- CodeIgniter apps toxic with: `open-telemetry/opentelemetry-auto-laravel`

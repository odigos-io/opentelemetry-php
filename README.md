# @odigos/opentelemetry-php

Odigos distribution of OpenTelemetry for PHP.<br />
To auto-instrument PHP with OpenTelemetry, we need a few things:

- PHP extension (`opentelemetry.so`)
- PHP libraries (`composer.json`)
- Script with exporter (`index.php`)
- Configuration file with pointers to all of the above (`opentelemetry.ini`)

**WARNING: It is important to note that the `opentelemetry.so` binaries are compiled per PHP version, which is why every PHP version has it's own agent!**

# Deploying an agent

To deploy an agent:

1. We need to copy the agent folder into our cluster under a pre-defined path (such as `/var/odigos/php/${PHP_VERSION}/vendor/autoload.php`), these paths are defined and must be changed accordingly in each `index.php` script.

2. We need to tell the instrumented app to load the OTel files, to do that we need to give the container an env called `OTEL_PHP_AUTOLOAD_ENABLED`, it should equal `true`.

3. We need to tell the instrumented app where to find our script and binaries, to do that we need to give the container an env called `PHP_INI_SCAN_DIR`, it should point at the dir that contains the agent files (e.g `/var/odigos/php/8.1:`).

NOTE: for step 3 we used a colon at the end of the appointed dir, that is required by the env itself, here's why:

> How to use `PHP_INI_SCAN_DIR` env with colon (:) separator...<br />
> Assuming `/etc/php.d/\*.ini` is the default configuration file;

> No env;<br />
> RUN `php`
>
> - will load all files in `/etc/php.d/\*.ini` (default)

> No colon;<br />
> RUN `PHP_INI_SCAN_DIR=/usr/local/etc/php.d php`
>
> - will load all files in `/usr/local/etc/php.d/*.ini` (custom)
> - and ignore `/etc/php.d/\_.ini` (default)

> Colon at start;<br />
> RUN `PHP_INI_SCAN_DIR=:/usr/local/etc/php.d php`
>
> - will 1st load all files in `/etc/php.d/*.ini` (default)
> - then load `/usr/local/etc/php.d/\_.ini` (custom)

> Colon at end;<br />
> RUN `PHP_INI_SCAN_DIR=/usr/local/etc/php.d: php`
>
> - will 1st load all files in `/usr/local/etc/php.d/*.ini` (custom)
> - then load `/etc/php.d/\_.ini` (default)

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
  // Libs extra base
  "open-telemetry/opentelemetry-auto-io": "^0.0.13",
  "open-telemetry/opentelemetry-auto-curl": "^0.0.4",
  "open-telemetry/opentelemetry-auto-pdo": "^0.0.19",
  "open-telemetry/opentelemetry-auto-doctrine": "^0.1.0",
  // Libs extra comms
  "open-telemetry/opentelemetry-auto-ext-amqp": "^0.0.5",
  "open-telemetry/opentelemetry-auto-ext-rdkafka": "^0.0.2",
  "open-telemetry/opentelemetry-auto-mysqli": "^0.0.2",
  "open-telemetry/opentelemetry-auto-mongodb": "^0.0.8",
  "open-telemetry/opentelemetry-auto-openai-php": "^0.0.3",
  // Libs extra frameworks
  "open-telemetry/opentelemetry-auto-slim": "^1.1.0",
  "open-telemetry/opentelemetry-auto-codeigniter": "^0.0.9",
  "open-telemetry/opentelemetry-auto-symfony": "^1.0.0",
  "open-telemetry/opentelemetry-auto-laravel": "^1.1.1",
  "open-telemetry/opentelemetry-auto-cakephp": "^0.0.4",
  "open-telemetry/opentelemetry-auto-yii": "^0.0.6",
  "open-telemetry/opentelemetry-auto-wordpress": "^0.0.17"
}
```

### 8.0 limitations

The following libraries are incompatible and cannot be used with version 8.0 at all:

```
open-telemetry/opentelemetry-auto-io
open-telemetry/opentelemetry-auto-curl
open-telemetry/opentelemetry-auto-pdo
open-telemetry/opentelemetry-auto-doctrine
open-telemetry/opentelemetry-auto-ext-amqp
open-telemetry/opentelemetry-auto-ext-rdkafka
open-telemetry/opentelemetry-auto-mysqli
open-telemetry/opentelemetry-auto-openai-php
```

NOTE: The rest of the libraries have reached END OF LIFE support for version 8.0, and are listed with "maxed out" versions below:

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
  "open-telemetry/opentelemetry-auto-mongodb": "<=0.0.7",
  "open-telemetry/opentelemetry-auto-slim": "<=1.0.7",
  "open-telemetry/opentelemetry-auto-codeigniter": "<=0.0.8",
  "open-telemetry/opentelemetry-auto-symfony": "<=1.0.0beta30",
  "open-telemetry/opentelemetry-auto-laravel": "<=1.0.1",
  "open-telemetry/opentelemetry-auto-cakephp": "<=0.0.3",
  "open-telemetry/opentelemetry-auto-yii": "<=0.0.5",
  "open-telemetry/opentelemetry-auto-wordpress": "<=0.0.16"
}
```

### 8.1 limitations

The following libraries are incompatible and cannot be used with version 8.1 at all:<br />

```
open-telemetry/opentelemetry-auto-io
open-telemetry/opentelemetry-auto-curl
open-telemetry/opentelemetry-auto-pdo
open-telemetry/opentelemetry-auto-doctrine
open-telemetry/opentelemetry-auto-ext-amqp
open-telemetry/opentelemetry-auto-ext-rdkafka
open-telemetry/opentelemetry-auto-mysqli
```

NOTE: 8.1 allows `openai-php` unlike 8.0

### Toxic conflicts

- CodeIgniter apps will crash with `auto-laravel`

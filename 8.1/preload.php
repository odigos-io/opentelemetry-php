<?php

$paths = [
  [
    'include' => '/var/odigos/php/8.1/',
    'exclude' => [
      '.php-cs-fixer',
      'vendor/php-http/discovery/src/Composer',
      'vendor/composer',
      'Tests',
    ],
  ],
];

if (!extension_loaded('opentelemetry')) {
  echo 'OpenTelemetry extension not loaded' . PHP_EOL;
  return;
}

foreach ($paths as $path) {
  $directory = new RecursiveDirectoryIterator($path['include']);
  $fullTree  = new RecursiveIteratorIterator($directory);
  $phpFiles  = new RegexIterator(
    $fullTree,
    '/.+((?<!Test)+\.php$)/i',
    RecursiveRegexIterator::GET_MATCH
  );

  foreach ($phpFiles as $key => $file) {
    $filename = $file[0];

    foreach ($path['exclude'] as $exclude) {
      if (str_contains($filename, $exclude)) {
        continue 2;
      }
    }

    require_once $filename;
  }
}

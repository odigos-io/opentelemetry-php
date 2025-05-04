<?php

$paths = [
  [
    'include' => '/var/odigos/php/8.2/index.php',
    'exclude' => [],
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
    foreach ($path['exclude'] as $exclude) {
      if (str_contains($file[0], $exclude)) {
        continue 2;
      }
    }

    require_once $file[0];
  }
}

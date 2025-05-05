<?php

$paths = [
  [
    'dir' => '/var/odigos/php/8.4/',
    'include' => [
      'opentelemetry-auto-codeigniter',
      'codeigniter4',
    ],
    'exclude' => [
      '.phan',
      '.php-cs-fixer',
      'Composer',
      'composer',
      'Tests',
      'tests',
      'Test',
      'test',
    ],
  ],
];

if (!extension_loaded('opentelemetry')) {
  echo 'OpenTelemetry extension not loaded' . PHP_EOL;
  return;
}

foreach ($paths as $path) {
  $directory = new RecursiveDirectoryIterator($path['dir']);
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

    foreach ($path['include'] as $include) {
      if (!str_contains($filename, $include)) {
        continue 2;
      }
    }

    require_once $filename;
  }
}

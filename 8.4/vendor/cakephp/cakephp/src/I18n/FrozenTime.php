<?php

declare (strict_types=1);
namespace Odigos;

use Odigos\Cake\I18n\DateTime;
use function Odigos\Cake\Core\deprecationWarning;
deprecationWarning('5.0.0', 'Cake\I18n\FrozenTime is deprecated. Use Cake\I18n\DateTime instead');
\class_exists(DateTime::class);

<?php

declare (strict_types=1);
/**
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @copyright     Copyright (c) Brian Nesbitt <brian@nesbot.com>
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Chronos;

use DateTimeInterface;
/**
 * Handles formatting differences in text.
 *
 * Provides a swappable component for other libraries to leverage.
 * when localizing or customizing the difference output.
 *
 * @internal
 */
class DifferenceFormatter implements \Cake\Chronos\DifferenceFormatterInterface
{
    /**
     * The text translator object
     *
     * @var \Cake\Chronos\Translator
     */
    protected \Cake\Chronos\Translator $translate;
    /**
     * Constructor.
     *
     * @param \Cake\Chronos\Translator|null $translate The text translator object.
     */
    public function __construct(?\Cake\Chronos\Translator $translate = null)
    {
        $this->translate = $translate ?: new \Cake\Chronos\Translator();
    }
    /**
     * @inheritDoc
     */
    public function diffForHumans(\Cake\Chronos\ChronosDate|DateTimeInterface $first, \Cake\Chronos\ChronosDate|DateTimeInterface|null $second = null, bool $absolute = \false): string
    {
        $isNow = $second === null;
        if ($second === null) {
            if ($first instanceof \Cake\Chronos\ChronosDate) {
                $second = new \Cake\Chronos\ChronosDate(\Cake\Chronos\Chronos::now());
            } else {
                $second = \Cake\Chronos\Chronos::now($first->getTimezone());
            }
        }
        assert($first instanceof \Cake\Chronos\ChronosDate && $second instanceof \Cake\Chronos\ChronosDate || $first instanceof DateTimeInterface && $second instanceof DateTimeInterface);
        $diffInterval = $first->diff($second);
        switch (\true) {
            case $diffInterval->y > 0:
                $unit = 'year';
                $count = $diffInterval->y;
                break;
            case $diffInterval->m >= 2:
                $unit = 'month';
                $count = $diffInterval->m;
                break;
            case $diffInterval->days >= \Cake\Chronos\Chronos::DAYS_PER_WEEK * 3:
                $unit = 'week';
                $count = (int) ($diffInterval->days / \Cake\Chronos\Chronos::DAYS_PER_WEEK);
                break;
            case $diffInterval->d > 0:
                $unit = 'day';
                $count = $diffInterval->d;
                break;
            case $diffInterval->h > 0:
                $unit = 'hour';
                $count = $diffInterval->h;
                break;
            case $diffInterval->i > 0:
                $unit = 'minute';
                $count = $diffInterval->i;
                break;
            default:
                $count = $diffInterval->s;
                $unit = 'second';
                break;
        }
        $time = $this->translate->plural($unit, $count, ['count' => $count]);
        if ($absolute) {
            return $time;
        }
        $isFuture = $diffInterval->invert === 1;
        $transId = $isNow ? $isFuture ? 'from_now' : 'ago' : ($isFuture ? 'after' : 'before');
        // Some langs have special pluralization for past and future tense.
        $tryKeyExists = $unit . '_' . $transId;
        if ($this->translate->exists($tryKeyExists)) {
            $time = $this->translate->plural($tryKeyExists, $count, ['count' => $count]);
        }
        return $this->translate->singular($transId, ['time' => $time]);
    }
}

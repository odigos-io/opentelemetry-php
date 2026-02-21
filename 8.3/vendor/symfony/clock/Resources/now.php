<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\Clock;

if (!\function_exists(\Symfony\Component\Clock\now::class)) {
    /**
     * @throws \DateMalformedStringException When the modifier is invalid
     */
    function now(string $modifier = 'now'): \Symfony\Component\Clock\DatePoint
    {
        if ('now' !== $modifier) {
            return new \Symfony\Component\Clock\DatePoint($modifier);
        }
        $now = \Symfony\Component\Clock\Clock::get()->now();
        return $now instanceof \Symfony\Component\Clock\DatePoint ? $now : \Symfony\Component\Clock\DatePoint::createFromInterface($now);
    }
}

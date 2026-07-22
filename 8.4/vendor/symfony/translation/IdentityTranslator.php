<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Odigos\Symfony\Component\Translation;

use Odigos\Symfony\Contracts\Translation\LocaleAwareInterface;
use Odigos\Symfony\Contracts\Translation\TranslatorInterface;
use Odigos\Symfony\Contracts\Translation\TranslatorTrait;
/**
 * IdentityTranslator does not translate anything.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class IdentityTranslator implements TranslatorInterface, LocaleAwareInterface
{
    use TranslatorTrait;
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}

<?php

declare (strict_types=1);
namespace Odigos\Doctrine\Inflector\Rules\Portuguese;

use Odigos\Doctrine\Inflector\GenericLanguageInflectorFactory;
use Odigos\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends GenericLanguageInflectorFactory
{
    protected function getSingularRuleset(): Ruleset
    {
        return Rules::getSingularRuleset();
    }
    protected function getPluralRuleset(): Ruleset
    {
        return Rules::getPluralRuleset();
    }
}

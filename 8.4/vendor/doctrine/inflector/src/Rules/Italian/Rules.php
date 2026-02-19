<?php

declare (strict_types=1);
namespace Doctrine\Inflector\Rules\Italian;

use Doctrine\Inflector\Rules\Patterns;
use Doctrine\Inflector\Rules\Ruleset;
use Doctrine\Inflector\Rules\Substitutions;
use Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset(): Ruleset
    {
        return new Ruleset(new Transformations(...\Doctrine\Inflector\Rules\Italian\Inflectible::getSingular()), new Patterns(...\Doctrine\Inflector\Rules\Italian\Uninflected::getSingular()), (new Substitutions(...\Doctrine\Inflector\Rules\Italian\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset(): Ruleset
    {
        return new Ruleset(new Transformations(...\Doctrine\Inflector\Rules\Italian\Inflectible::getPlural()), new Patterns(...\Doctrine\Inflector\Rules\Italian\Uninflected::getPlural()), new Substitutions(...\Doctrine\Inflector\Rules\Italian\Inflectible::getIrregular()));
    }
}

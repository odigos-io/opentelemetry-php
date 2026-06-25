<?php

namespace Laravel\Prompts\Elements;

class Element
{
    public static function heading(string $text): \Laravel\Prompts\Elements\Heading
    {
        return new \Laravel\Prompts\Elements\Heading($text);
    }
    /**
     * @param  array<int, string>  $items
     */
    public static function bulletedList(array $items, bool $spaced = \false): \Laravel\Prompts\Elements\BulletedList
    {
        return new \Laravel\Prompts\Elements\BulletedList($items, $spaced);
    }
    /**
     * @param  array<int, string>  $items
     */
    public static function numberedList(array $items, bool $spaced = \false): \Laravel\Prompts\Elements\NumberedList
    {
        return new \Laravel\Prompts\Elements\NumberedList($items, $spaced);
    }
    /**
     * @param  array<string, string>  $items
     */
    public static function keyValueList(array $items): \Laravel\Prompts\Elements\KeyValueList
    {
        return new \Laravel\Prompts\Elements\KeyValueList($items);
    }
}

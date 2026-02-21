<?php

namespace Illuminate\JsonSchema\Types;

class BooleanType extends \Illuminate\JsonSchema\Types\Type
{
    /**
     * Set the type's default value.
     */
    public function default(bool $value): static
    {
        $this->default = $value;
        return $this;
    }
}

<?php

namespace Illuminate\Database\Eloquent\Concerns;

use Illuminate\Support\Str;
trait HasVersion4Uuids
{
    use \Illuminate\Database\Eloquent\Concerns\HasUuids;
    /**
     * Generate a new UUID (version 4) for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        return (string) Str::orderedUuid();
    }
}

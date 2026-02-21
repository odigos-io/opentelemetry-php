<?php

namespace Illuminate\Http\Resources;

class MissingValue implements \Illuminate\Http\Resources\PotentiallyMissing
{
    /**
     * Determine if the object should be considered "missing".
     *
     * @return bool
     */
    public function isMissing()
    {
        return \true;
    }
}

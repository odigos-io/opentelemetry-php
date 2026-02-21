<?php

namespace Illuminate\Cache;

use Illuminate\Contracts\Cache\Store;
abstract class TaggableStore implements Store
{
    /**
     * Begin executing a new tags operation.
     *
     * @param  array|mixed  $names
     * @return \Illuminate\Cache\TaggedCache
     */
    public function tags($names)
    {
        return new \Illuminate\Cache\TaggedCache($this, new \Illuminate\Cache\TagSet($this, is_array($names) ? $names : func_get_args()));
    }
}

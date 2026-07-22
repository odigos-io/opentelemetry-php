<?php

namespace Odigos\Illuminate\Http\Resources\JsonApi\Concerns;

use Odigos\Illuminate\Http\Request;
use Odigos\Illuminate\Http\Resources\JsonApi\JsonApiRequest;
trait ResolvesJsonApiRequest
{
    /**
     * Resolve a JSON API request instance from the given HTTP request.
     *
     * @return \Illuminate\Http\Resources\JsonApi\JsonApiRequest
     */
    protected function resolveJsonApiRequestFrom(Request $request)
    {
        return $request instanceof JsonApiRequest ? $request : JsonApiRequest::createFrom($request);
    }
}

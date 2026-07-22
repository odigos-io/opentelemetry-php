<?php

namespace Odigos\Illuminate\Routing\Exceptions;

use Odigos\Symfony\Component\HttpKernel\Exception\HttpException;
class InvalidSignatureException extends HttpException
{
    /**
     * Create a new exception instance.
     */
    public function __construct()
    {
        parent::__construct(403, 'Invalid signature.');
    }
}

<?php

namespace Odigos\Illuminate\Contracts\Validation;

use Odigos\Illuminate\Validation\Validator;
interface ValidatorAwareRule
{
    /**
     * Set the current validator.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return $this
     */
    public function setValidator(Validator $validator);
}

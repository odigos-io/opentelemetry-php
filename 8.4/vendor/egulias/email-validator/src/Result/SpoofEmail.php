<?php

namespace Odigos\Egulias\EmailValidator\Result;

use Odigos\Egulias\EmailValidator\Result\Reason\SpoofEmail as ReasonSpoofEmail;
class SpoofEmail extends InvalidEmail
{
    public function __construct()
    {
        $this->reason = new ReasonSpoofEmail();
        parent::__construct($this->reason, '');
    }
}

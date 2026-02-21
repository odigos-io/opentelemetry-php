<?php

namespace Odigos\Egulias\EmailValidator\Parser;

use Odigos\Egulias\EmailValidator\Result\Result;
use Odigos\Egulias\EmailValidator\Result\InvalidEmail;
use Odigos\Egulias\EmailValidator\Result\Reason\CommentsInIDRight;
class IDLeftPart extends LocalPart
{
    protected function parseComments(): Result
    {
        return new InvalidEmail(new CommentsInIDRight(), $this->lexer->current->value);
    }
}

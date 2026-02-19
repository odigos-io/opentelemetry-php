<?php

namespace Odigos\Egulias\EmailValidator\Parser;

use Odigos\Egulias\EmailValidator\EmailLexer;
use Odigos\Egulias\EmailValidator\Result\Result;
use Odigos\Egulias\EmailValidator\Result\ValidEmail;
use Odigos\Egulias\EmailValidator\Result\InvalidEmail;
use Odigos\Egulias\EmailValidator\Result\Reason\ExpectingATEXT;
class IDRightPart extends DomainPart
{
    protected function validateTokens(bool $hasComments): Result
    {
        $invalidDomainTokens = [EmailLexer::S_DQUOTE => \true, EmailLexer::S_SQUOTE => \true, EmailLexer::S_BACKTICK => \true, EmailLexer::S_SEMICOLON => \true, EmailLexer::S_GREATERTHAN => \true, EmailLexer::S_LOWERTHAN => \true];
        if (isset($invalidDomainTokens[$this->lexer->current->type])) {
            return new InvalidEmail(new ExpectingATEXT('Invalid token in domain: ' . $this->lexer->current->value), $this->lexer->current->value);
        }
        return new ValidEmail();
    }
}

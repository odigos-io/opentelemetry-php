<?php

namespace Odigos\Egulias\EmailValidator\Parser\CommentStrategy;

use Odigos\Egulias\EmailValidator\EmailLexer;
use Odigos\Egulias\EmailValidator\Result\Result;
use Odigos\Egulias\EmailValidator\Result\ValidEmail;
use Odigos\Egulias\EmailValidator\Result\InvalidEmail;
use Odigos\Egulias\EmailValidator\Result\Reason\ExpectingATEXT;
class DomainComment implements CommentStrategy
{
    public function exitCondition(EmailLexer $lexer, int $openedParenthesis): bool
    {
        return !($openedParenthesis === 0 && $lexer->isNextToken(EmailLexer::S_DOT));
    }
    public function endOfLoopValidations(EmailLexer $lexer): Result
    {
        //test for end of string
        if (!$lexer->isNextToken(EmailLexer::S_DOT)) {
            return new InvalidEmail(new ExpectingATEXT('DOT not found near CLOSEPARENTHESIS'), $lexer->current->value);
        }
        //add warning
        //Address is valid within the message but cannot be used unmodified for the envelope
        return new ValidEmail();
    }
    public function getWarnings(): array
    {
        return [];
    }
}

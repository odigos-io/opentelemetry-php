<?php

namespace Odigos\Egulias\EmailValidator\Parser\CommentStrategy;

use Odigos\Egulias\EmailValidator\EmailLexer;
use Odigos\Egulias\EmailValidator\Result\Result;
use Odigos\Egulias\EmailValidator\Warning\Warning;
interface CommentStrategy
{
    /**
     * Return "true" to continue, "false" to exit
     */
    public function exitCondition(EmailLexer $lexer, int $openedParenthesis): bool;
    public function endOfLoopValidations(EmailLexer $lexer): Result;
    /**
     * @return Warning[]
     */
    public function getWarnings(): array;
}

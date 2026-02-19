<?php

namespace Odigos\Egulias\EmailValidator\Parser\CommentStrategy;

use Odigos\Egulias\EmailValidator\EmailLexer;
use Odigos\Egulias\EmailValidator\Result\Result;
use Odigos\Egulias\EmailValidator\Result\ValidEmail;
use Odigos\Egulias\EmailValidator\Warning\CFWSNearAt;
use Odigos\Egulias\EmailValidator\Result\InvalidEmail;
use Odigos\Egulias\EmailValidator\Result\Reason\ExpectingATEXT;
use Odigos\Egulias\EmailValidator\Warning\Warning;
class LocalComment implements CommentStrategy
{
    /**
     * @var array<int, Warning>
     */
    private $warnings = [];
    public function exitCondition(EmailLexer $lexer, int $openedParenthesis): bool
    {
        return !$lexer->isNextToken(EmailLexer::S_AT);
    }
    public function endOfLoopValidations(EmailLexer $lexer): Result
    {
        if (!$lexer->isNextToken(EmailLexer::S_AT)) {
            return new InvalidEmail(new ExpectingATEXT('ATEX is not expected after closing comments'), $lexer->current->value);
        }
        $this->warnings[CFWSNearAt::CODE] = new CFWSNearAt();
        return new ValidEmail();
    }
    public function getWarnings(): array
    {
        return $this->warnings;
    }
}

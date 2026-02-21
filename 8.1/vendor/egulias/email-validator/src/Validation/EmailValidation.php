<?php

namespace Odigos\Egulias\EmailValidator\Validation;

use Odigos\Egulias\EmailValidator\EmailLexer;
use Odigos\Egulias\EmailValidator\Result\InvalidEmail;
use Odigos\Egulias\EmailValidator\Warning\Warning;
interface EmailValidation
{
    /**
     * Returns true if the given email is valid.
     *
     * @param string     $email      The email you want to validate.
     * @param EmailLexer $emailLexer The email lexer.
     *
     * @return bool
     */
    public function isValid(string $email, EmailLexer $emailLexer): bool;
    /**
     * Returns the validation error.
     *
     * @return InvalidEmail|null
     */
    public function getError(): ?InvalidEmail;
    /**
     * Returns the validation warnings.
     *
     * @return Warning[]
     */
    public function getWarnings(): array;
}

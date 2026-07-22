<?php

declare (strict_types=1);
namespace Odigos\Termwind\Helpers;

use Odigos\Symfony\Component\Console\Formatter\OutputFormatter;
use Odigos\Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Odigos\Symfony\Component\Console\Output\OutputInterface;
use Odigos\Symfony\Component\Console\Question\Question;
/**
 * @internal
 */
final class QuestionHelper extends SymfonyQuestionHelper
{
    /**
     * {@inheritdoc}
     */
    protected function writePrompt(OutputInterface $output, Question $question): void
    {
        $text = OutputFormatter::escapeTrailingBackslash($question->getQuestion());
        $output->write($text);
    }
}

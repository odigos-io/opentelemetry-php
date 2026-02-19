<?php

declare (strict_types=1);
namespace OpenTelemetry\API\Behavior\Internal\LogWriter;

class StreamLogWriter implements \OpenTelemetry\API\Behavior\Internal\LogWriter\LogWriterInterface
{
    private $stream;
    public function __construct(string $destination)
    {
        $stream = fopen($destination, 'a');
        if ($stream) {
            $this->stream = $stream;
        } else {
            throw new \RuntimeException(sprintf('Unable to open %s for writing', $destination));
        }
    }
    #[\Override]
    public function write($level, string $message, array $context): void
    {
        fwrite($this->stream, \OpenTelemetry\API\Behavior\Internal\LogWriter\Formatter::format($level, $message, $context));
    }
}

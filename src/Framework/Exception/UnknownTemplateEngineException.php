<?php

namespace Romano\Framework\Exception;

use Throwable;

class UnknownTemplateEngineException extends \Exception
{
    public function __construct(string $engine, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Select a supported Template render engine, %s is unsupported', $engine),
            $code,
            $previous
        );
    }
}
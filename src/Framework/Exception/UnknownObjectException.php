<?php

namespace Romano\Framework\Exception;

use Throwable;

class UnknownObjectException extends \Exception
{
    public function __construct(string $object, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Cannot instantiate a unknown object of class %s', $object),
            $code,
            $previous
        );
    }
}
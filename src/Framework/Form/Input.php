<?php

namespace Romano\Framework\Form;

class Input
{
    private $submissions;
    
    public function __construct()
    {
        $this->submissions = $_REQUEST;
    }

    public function isSubmitted(string $fieldName): bool
    {
        return $this->get($fieldName) !== null;
    }

    public function get($fieldName = '', $default = null)
    {
        return $this->submissions[$fieldName] ?? $default;
    }
}

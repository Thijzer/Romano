<?php

namespace Romano\Component\Common;

class ClassNameReference
{
    /** @var string */
    private $className;

    public function __construct($object)
    {
        $this->className = \get_class($object);
    }

    /** @return string */
    public function getClassName(): string
    {
        return $this->className;
    }

    /** @return bool|string */
    public function getShortName()
    {
        return substr(strrchr($this->getClassName(), '\\'), 1);
    }

    /**
     * @param object $object
     *
     * @return bool
     */
    public function equals(object $object): bool
    {
        return $this->is((new self($object))->getClassName());
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function is(string $className): bool
    {
        return $this->getClassName() === $className;
    }

    /** @return string */
    public function __toString(): string
    {
        return $this->getClassName();
    }
}

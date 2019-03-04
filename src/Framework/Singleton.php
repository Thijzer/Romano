<?php

namespace Romano\Framework;

class Singleton
{
    private static $uniqueInstance = [];

    /**
     * @param object $object
     * @param string|null $reference
     */
    public static function setInstance(object $object, string $reference = null): void
    {
        $objectName = $reference ?: \get_class($object);
        static::$uniqueInstance[$objectName] = $object;
    }

    /**
     * @param string $objectName
     *
     * @return object $object
     *
     * @throws Exception\UnknownObjectException
     */
    public static function getInstance(string $objectName)
    {
        if (!isset(static::$uniqueInstance[$objectName])) {
            throw new Exception\UnknownObjectException($objectName);
        }

        return static::$uniqueInstance[$objectName];
    }

    public static function clearInstance(string $objectName): void
    {
        unset(static::$uniqueInstance[$objectName]);
    }

    private function  __construct(){}
    private function __clone(){}
}

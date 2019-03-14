<?php

namespace Romano\Framework\Functions;

class ArrayFunctions
{
    public const delimiter = '.';

    public static function indexBy($newIndex, array $files)
    {
        if (!isset($files[0][$newIndex])) {
            return [];
        }
        foreach ($files as $value) {
            $tmp[$value[$newIndex]] = $value;
        }
        return $tmp;
    }

    /**
     * returns an cleaned array on provided keys
     */
    static function returnOnKeys($rr, $keys) {
        // arraflip rotates the array key => val to val => key
        return array_intersect_key($rr, array_flip($keys));
    }

    /**
     * returns an array with replaced values
     */
    public static function replaceValue($haystack, $needle, $replaceValue)
    {
        foreach (in_array($needle, $haystack) as $key) {
            $haystack[$key] = $replaceValue;
        }
        return $haystack;
    }

    private function checkLastKey($rr, $key)
    {
        return ($key === self::getLastKey($rr));
    }

    /**
     * @param array $array
     *
     * @return mixed
     */
    public static function getLastKey(array $array)
    {
        end($array);
        return key($array);
    }

    /**
     * @param array $array
     *
     * @return mixed
     */
    public static function getLastValue(array $array)
    {
        return $array[self::getLastKey($array)];
    }

    /**
     * ISSUE with unflatten
     * label-23 => becomes label[23]
     * but label => resets label[] via overwriting.
     *
     * Reverse flatten an associative array to multidimensional one
     * by separating keys on prefix.
     *
     * @param array  $array
     * @param string $prefix
     *
     * @return array
     */
    public static function unflatten(array $array, string $prefix = '.')
    {
        $output = [];
        foreach ($array as $key => $value) {
            static::arraySet($output, $key, $value, $prefix);
            if (\is_array($value) && !strpos($key, $prefix)) {
                $nested = static::unflatten($value, $prefix);
                $output[$key] = $nested;
            }
        }
        return $output;
    }

    public static function arraySet(array &$array, string $keys, $value): array
    {
        $keys = \explode(self::delimiter, $keys);
        while (\count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($array[$key]) || !\is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
//        foreach ($keys = \explode(self::delimiter, $keys) as $key) {
//            if (!isset($array[$key]) || !\is_array($array[$key])) {
//                $array[$key] = [];
//            }
//            $array = &$array[$key];
//        }
//        $array[end($keys)] = $value;

        return $array;
    }

    public static function arrayGet(array $keys, array $searchableValues)
    {
        $keys = \count($keys) > 1 ? $keys : \explode(self::delimiter, current($keys));

        foreach ($keys as $key) {
            $searchableValues = $searchableValues[$key] ?? null;
        }

        return $searchableValues;
    }

    /**
     * Checks weither the array is associative.
     *
     * @param array $arr
     *
     * @return bool
     */
    public static function isAssoc(array $arr)
    {
        if ([] === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, \count($arr) - 1);
    }
    /**
     * Flattens an multi-dimensional array to associative array
     * by adding combining the keys with a prefix.
     *
     * @param array  $array
     * @param string $prefix
     * @param mixed  $separator
     *
     * @return array
     */
    public static function flatten(array $array, $separator = '.', $prefix = '')
    {
        $result = [];
        foreach ($array as $key => $value) {
            if (\is_array($value)) {
                $result += self::flatten($value, $separator, $prefix.$key.$separator);
                continue;
            }
            $result[$prefix.$key] = $value;
        }
        return $result;
    }
    public static function flattenSetKey(array &$array, $referenceKey, $value, $separator = '.')
    {
        $keys = explode($separator, $referenceKey);
        foreach ($keys as $key) {
            if (!\is_array($array[$key])) {
                $array[$key] = $value;
                return;
            }
            $array = &$array[$key];
        }
    }
    /**
     * Normalizes array keys to integers.
     *
     * @param array $param
     *
     * @return array
     */
    public static function normalizeKeys(array $param)
    {
        $keys = [];
        foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($param)) as $key => $val) {
            $keys[$key] = '';
        }
        $data = [];
        foreach ($param as $values) {
            $data[] = array_merge($keys, $values);
        }
        return $data;
    }
}

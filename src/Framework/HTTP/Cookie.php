<?php

namespace Romano\Framework\HTTP;

class Cookie
{
    public static function set(string $name, $data, int $expiry): void
    {
        setcookie($name, \is_array($data) ? json_encode($data) : $data, $expiry);
    }

    public static function get(string $name): array
    {
        return (array) json_decode($_COOKIE[$name] ?? '');
    }

    public static function exists(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    public static function delete($name): void
    {
        self::set($name, '', time() - 1);
        unset($_COOKIE[$name]);
    }
}

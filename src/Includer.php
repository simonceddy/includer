<?php
namespace Eddy\Includer;

final class Includer
{
    protected static function makeLoaderWithArgs(string $filename)
    {
        return \Closure::fromCallable(function (array $args = []) use ($filename) {    
            if (!empty($args)) {
                extract($args);
            }

            return include $filename;
        });
    }

    public static function make(string $filename, bool $args = false)
    {
        if (!file_exists($filename)) {
            throw new \Exception("Could not locate {$filename}!");
        }

        if ($args) {
            $loader = self::makeLoaderWithArgs($filename);
        } else {
            $loader = \Closure::fromCallable(function () use ($filename) {
                return include $filename;
            });
        }

        return $loader;
    }

    public static function load(string $filename, array $args = [])
    {
        $loader = self::make($filename, !empty($args));
        return $loader($args);
    }
}

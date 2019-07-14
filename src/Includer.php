<?php
namespace Eddy\Includer;

final class Includer
{
    /**
     * Creates a Closure based loader that can accept an array of arguments.
     * 
     * The args array is extracted by the Closure before the file is included.
     * This allows passing named variables to the included files.
     * 
     * @internal used to create loaders for make()
     *
     * @param string $filename
     * @param array $args
     *
     * @return \Closure
     */
    protected static function makeLoaderWithArgs(string $filename, array $args = [])
    {
        if (!empty($args)) {
            return \Closure::fromCallable(
                function (array $arguments = []) use ($filename, $args) {

                    if (!empty($arguments)) {
                        $args = array_merge($args, $arguments);
                    }
                    extract($args);
        
                    return include $filename;
                }
            );
        }

        return \Closure::fromCallable(function (array $args = []) use ($filename) {    
            if (!empty($args)) {
                extract($args);
            }

            return include $filename;
        });
    }

    /**
     * Creates a Closure based loader for the given filename.
     * 
     * If $args is true the returned loader can accept an array of arguments.
     * 
     * The arguments array is extracted before the file is included. This
     * allows passing named variables to the included files.
     * 
     * If $args is an array the returned loader will use $args and does not
     * require any additional arguments when called. The loader can, however,
     * accept an additional arguments array
     *
     * @param string $filename
     * @param bool|array $args
     *
     * @return \Closure
     */
    public static function make(string $filename, $args = false)
    {
        if (!file_exists($filename)) {
            throw new \Exception("Could not locate {$filename}!");
        }

        if (true === $args || is_array($args)) {
            $loader = self::makeLoaderWithArgs($filename, true === $args ? [] : $args);
        } else {
            $loader = \Closure::fromCallable(function () use ($filename) {
                return include $filename;
            });
        }

        return $loader;
    }

    /**
     * Include a file through a Closure based loader.
     * 
     * If the $args array is set and is not empty it will be passed to the
     * created loader and its contents extracted. This allows passing named
     * variables to the included files.
     * 
     * Returns the value of including the given file. If the included file has
     * no return value it will return null.
     *
     * @param string $filename
     * @param array $args
     *
     * @return void|mixed
     */
    public static function load(string $filename, array $args = [])
    {
        $loader = self::make($filename, empty($args) ? false : true);
        return $loader($args);
    }
}

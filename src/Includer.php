<?php
namespace Eddy\Includer;

final class Includer
{
    /**
     * Creates a Closure based loader for the given filename.
     * 
     * The created loader can accept an array of arguments. The arguments array
     * is extracted before the file is included. This allows passing named
     * variables to the included files.
     * 
     * If $args is an array the returned loader will use $args and does not
     * require any additional arguments when called. The loader can, however,
     * still accept an additional arguments array
     *
     * @param string $filename
     * @param array $args
     *
     * @return \Closure
     */
    public static function make(string $filename, array $args = [])
    {
        if (!file_exists($filename)) {
            throw new \Exception("Could not locate {$filename}!");
        }

        $loader = \Closure::fromCallable(
            function (array $arguments = []) use ($filename, $args) {

                empty($arguments) ?: $args = array_merge($args, $arguments);
                
                empty($args) ?: extract($args);
    
                return include $filename;
            }
        );

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
        $loader = self::make($filename);
        return $loader($args);
    }
}

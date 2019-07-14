<?php
use Eddy\Includer\Includer;

if (!function_exists('make_includer')) {
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
    function make_includer(string $filename, $args = false)
    {
        return Includer::make($filename, $args);
    }
}

if (!function_exists('include_file')) {
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
     * @return null|mixed
     */
    function include_file(string $filename, array $args = [])
    {
        return Includer::load($filename, $args);
    }
}

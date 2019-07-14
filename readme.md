# simoneddy/includer

Includer is a simple utility that wraps PHPs `include` in a Closure.

It contains only a single class with a few static methods, as well as two wrapper functions.

## Usage

Using the Includer is very simple:

```php
// Includer's make() static method can create a Closure based includer
// that can be called whenever required.
$loader = Eddy\Includer\Includer::make('my_included_file.php');

// The library also includes a wrapper function that does the same thing:
$loader = make_includer('my_included_file.php');

$loader(); // Includes my_included_file.php


// Includer can perform includes with the load() static method
$returnedValue = Eddy\Includer\Includer::load('my_included_file.php');

// Includer also includes a wrapper function for this process
$returnedValue = include_file('my_included_file.php');
```

You can pass variables to the includer

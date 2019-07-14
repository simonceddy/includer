# simoneddy/includer

Includer is a simple utility that wraps PHPs `include` in a Closure.

It contains only a single class with a few static methods, as well as two wrapper functions.

## Installation

Includer can be installed with Composer:

```sh
composer require simoneddy/includer
```

## Usage

Using the Includer is very simple:

```php
// Includer's make() static method can create a Closure based includer
// that can be called whenever required.
$loader = Eddy\Includer\Includer::make('my_included_file.php');

// The library includes a wrapper function that does the same thing:
$loader = make_includer('my_included_file.php');

$loader(); // Includes my_included_file.php


// Includer can perform includes with the load() static method
$returnedValue = Eddy\Includer\Includer::load('my_included_file.php');

// Includer also includes a wrapper function for this process
$returnedValue = include_file('my_included_file.php');
```

___

You can pass an associative array of variables to the includer. The contents of this array will be extracted, allowing passing named variables to the included file.

```php
// my_included_file.php
$data['my_cool_key'] => 'My Great Value';
```

```php
$data = [];

include_file('my_included_file.php', ['data' => $data]);

var_dump($data); // array(1) { "my_cool_key"] => string('My great Value') }
```

___

PHP-Generics
============

Boredom and a day: Simple generics for PHP


What are generics?
==================
Generics allows you to write type safe code against multiple types.

Installation
============
To install with composer add this to your `composer.json`:
```javascript
{
    "require": {
      "timetoogo/php-generics": "0.2"
    }
}
```

The implementation
==================
This library has taken advantage of PHP's namspacing and autoloading to emulate generic types. 
The generic classes are parsed, then converted into the required concrete types and stored in the
configurated directory.

Getting Started
===============
To get started with PHP-Generics must first set the following configuration:
 - `DevelopmentMode` - If development mode is set to true, the cached concrete types will be ignored and overwritten.
 - `RootPath` - The root of your project, the namespaces and class names must correspond with the directory and file paths.
 - `CachePath` - The path to use for storing the concrete implementations of the generic types.

```php
$Configuration = new \Generics\Configuration();
$Configuration->SetIsDevelopmentMode(true);
$Configuration->SetRootPath(__DIR__);
$Configuration->SetCachePath(__DIR__ . '/Cache');
//Register the generic auto loader
\Generics\Loader::Register($Configuration);
```
**All generic class files must end in `.generic.php`**

A Generic Example
=================
The below code demonstrate a simple generic type:

```php
class Maybe {
    private $MaybeValue;
    
    public function __construct(__TYPE__ $Value = null) {
        $this->MaybeValue = $Value;
    }
    
    public function HasValue() {
        return $this->MaybeValue !== null;
    }
    
    public function GetValue() {
        return $this->MaybeValue;
    }
    
    public function SetValue(__TYPE__ $Value = null) {
        $this->MaybeValue = $Value;
    }
}
```

Note the use of the `__TYPE__` magic constant, these are used as type parameters. 
The constant will be replaced with the concrete class type as required.
You can also use multiple type parameters in the form of `__TYPE1__`, `__TYPE2__` etc.
You can use type type parameters in any context: `$Var instanceof __TYPE__`, `func(__TYPE__)`, `__TYPE__::Foo()` etc. 

*Note that `__TYPE__` is an alias for `__TYPE1__`.*

Using the generic types
=======================

The type parameters of the class are defined as sub-namespaces and are *seperated by a special namespace `_`*:

Creating a concete implementation of the above generic can be done like so:
```php
$Maybe = Maybe\stdClass();
$Maybe->HasValue(); //false
$Maybe->SetValue(new stdClass());
$Maybe->HasValue(); //true
$Maybe->SetValue(new DateTime()); //ERROR

```

Below creates a Tuple with `__TYPE1__` as `stdClass` and `__TYPE2__` as `DateTime`:
```php 
$Tuple = new TupleOf\stdClass\_\DateTime();
```



**Limitation: All type parameter must be fully qualified:**

If you have a namespaced class `Foo\Bar\SomeClass` this must be specified in the generic type parameter:
```php
$Tuple = new TupleOf\Foo\Bar\SomeClass\_\DateTime();
```
This creates a Tuple with `__TYPE1__` as `Foo\Bar\SomeClass` and `__TYPE2__` as `DateTime`.

Other uses
==========
Generics can be used with inheritence:
```php
class TupleOfBarAndBaz extends TupleOf\Bar\_\Baz {
    //...
}
```

Generic interfaces and traits are also supported:
```php
interface IHaveOne {
    public function GetOne();
    public function SetOne(__TYPE__ $One);
}

class User implements IHaveOne\Account {
    private $One;
    
    public function GetOne(){
        return $this->One;
    }
    public function SetOne(Account $One) {
        $this->One = $One;
    }
}
```

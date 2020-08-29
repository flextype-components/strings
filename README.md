<h1 align="center">Strings Component</h1>

<p align="center">
<a href="https://github.com/flextype-components/strings/releases"><img alt="Version" src="https://img.shields.io/github/release/flextype-components/strings.svg?label=version&color=green"></a> <a href="https://github.com/flextype-components/strings"><img src="https://img.shields.io/badge/license-MIT-blue.svg?color=green" alt="License"></a> <a href="https://github.com/flextype-components/strings"><img src="https://img.shields.io/github/downloads/flextype-components/strings/total.svg?color=green" alt="Total downloads"></a> <a href="https://scrutinizer-ci.com/g/flextype-components/strings?branch=master"><img src="https://img.shields.io/scrutinizer/g/flextype-components/strings.svg?branch=master&color=green" alt="Quality Score"></a>
</p>
<br>

### Installation

With [Composer](https://getcomposer.org):

```
composer require flextype-components/strings
```

### Usage

```php
use Flextype\Component\Strings;
```

### Methods

| Method | Description |
|---|---|
| <a href="#strings_trimSlashes">`Strings::trimSlashes()`</a> | Removes any leading and trailing slashes from a string. |
| <a href="#strings_reduceSlashes">`Strings::reduceSlashes()`</a> | Reduces multiple slashes in a string to single slashes. |
| <a href="#strings_stripQuotes">`Strings::stripQuotes()`</a> | Removes single and double quotes from a string. |
| <a href="#strings_quotesToEntities">`Strings::quotesToEntities()`</a> | Convert single and double quotes to entities. |
| <a href="#strings_random">`Strings::random()`</a> | Creates a random string of characters. |
| <a href="#strings_increment">`Strings::increment()`</a> | Add's `_1` to a string or increment the ending number to allow `_2`, `_3`, etc. |
| <a href="#strings_length">`Strings::length()`</a> | Return the length of the given string. |
| <a href="#strings_lower">`Strings::lower()`</a> | Convert the given string to lower-case. |
| <a href="#strings_upper">`Strings::upper()`</a> | Convert the given string to upper-case. |

<hr>

#### <a name="strings_trimSlashes"></a> Method: `Strings::trimSlashes()`

Removes any leading and trailing slashes from a string.

```php
$string = Strings::trimSlashes('some string here/');
```

#### <a name="strings_reduceSlashes"></a> Method: `Strings::reduceSlashes()`

Reduces multiple slashes in a string to single slashes.

```php
$string = Strings::reduceSlashes('some//text//here');
```

#### <a name="strings_stripQuotes"></a> Method: `Strings::stripQuotes()`

Removes single and double quotes from a string.

```php
$string = Strings::stripQuotes('some "text" here');
```

#### <a name="strings_quotesToEntities"></a> Method: `Strings::quotesToEntities()`

Convert single and double quotes to entities.

```php
$string = Strings::quotesToEntities('some "text" here');
```

#### <a name="strings_random"></a> Method: `Strings::random()`

```php
// Get random string with predefined settings
$string = Strings::random();

// Get random string with custom length
$string = Strings::random(10);

// Get random string with custom length and custom keyspace
$string = Strings::random(4, '0123456789');
```

#### <a name="strings_increment"></a> Method: `Strings::increment()`

Add's `_1` to a string or increment the ending number to allow `_2`, `_3`, etc.

```php
$string = Strings::increment('page_1');
```

#### <a name="strings_length"></a> Method: `Strings::length()`

Return the length of the given string.

```php
$length = Strings::length('SG-1 returns from an off-world mission to P9Y-3C3');
```

#### <a name="strings_lower"></a> Method: `Strings::lower()`

Convert the given string to lower-case.

```php
$string = Strings::lower('SG-1 returns from an off-world mission to P9Y-3C3');
```

#### <a name="strings_upper"></a> Method: `Strings::upper()`

Convert the given string to upper-case.

```php
$string = Strings::upper('SG-1 returns from an off-world mission to P9Y-3C3');
```


### License
[The MIT License (MIT)](https://github.com/flextype-components/strings/blob/master/LICENSE.txt)
Copyright (c) 2020 [Sergey Romanenko](https://github.com/Awilum)

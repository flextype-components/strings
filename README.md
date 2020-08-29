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
| <a href="#strings_limit">`Strings::limit()`</a> | Limit the number of characters in a string. |
| <a href="#strings_studly">`Strings::studly()`</a> | Convert a value to studly caps case. |
| <a href="#strings_snake">`Strings::snake()`</a> | Convert a string to snake case. |
| <a href="#strings_camel">`Strings::camel()`</a> | Convert a string to camel case. |
| <a href="#strings_kebab">`Strings::kebab()`</a> | Convert a string to kebab case. |
| <a href="#strings_words">`Strings::words()`</a> | Limit the number of words in a string. |
| <a href="#strings_contains">`Strings::contains()`</a> | Determine if a given string contains a given substring. |
| <a href="#strings_substr">`Strings::substr()`</a> | Returns the portion of string specified by the start and length parameters. |
| <a href="#strings_ucfirst">`Strings::ucfirst()`</a> | Converts the first character of a UTF-8 string to upper case and leaves the other characters unchanged. |
| <a href="#strings_trim">`Strings::trim()`</a> | Strip whitespace (or other characters) from the beginning and end of a string. |
| <a href="#strings_capitalize">`Strings::capitalize()`</a> | Converts the first character of every word of string to upper case and the others to lower case. |

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

#### <a name="strings_limit"></a> Method: `Strings::limit()`

Limit the number of characters in a string.

```php
// Get string with predefined limit settings
$string = Strings::limit('SG-1 returns from an off-world mission to P9Y-3C3');

// Get string with limit 10
$string = Strings::limit('SG-1 returns from an off-world mission to P9Y-3C3', 10);

// Get string with limit 10 and append 'read more...'
$string = Strings::limit('SG-1 returns from an off-world mission to P9Y-3C3', 10, 'read more...');
```

#### <a name="strings_studly"></a> Method: `Strings::studly()`

Convert a value to studly caps case.

```php
$string = Strings::studly('foo_bar');
```

#### <a name="strings_snake"></a> Method: `Strings::snake()`

Convert a string to snake case.

```php
$string = Strings::snake('fooBar');
```

#### <a name="strings_camel"></a> Method: `Strings::camel()`

Convert a string to camel case.

```php
$string = Strings::camel('foo_bar');
```

#### <a name="strings_kebab"></a> Method: `Strings::kebab()`

Convert a string to kebab case.

```php
$string = Strings::kebab('fooBar');
```

#### <a name="strings_words"></a> Method: `Strings::words()`

Limit the number of words in a string.

```php
// Get the number of words in a string with predefined limit settings
$string = Strings::words('SG-1 returns from an off-world mission to P9Y-3C3');

// Get the number of words in a string with limit 3
$string = Strings::words('SG-1 returns from an off-world mission to P9Y-3C3', 3);

// Get the number of words in a string with limit 3 and append 'read more...'
$string = Strings::words('SG-1 returns from an off-world mission to P9Y-3C3', 3, 'read more...');
```

#### <a name="strings_contains"></a> Method: `Strings::contains()`

Determine if a given string contains a given substring.

```php
// Determine if a given string contains a given substring.
$result = Strings::contains('SG-1 returns from an off-world mission to P9Y-3C3', 'SG-1');

// Determine if a given string contains a given array of substrings.
$result = Strings::contains('SG-1 returns from an off-world mission to P9Y-3C3', ['SG-1', 'P9Y-3C3']);
```

#### <a name="strings_substr"></a> Method: `Strings::substr()`

Returns the portion of string specified by the start and length parameters.

```php
// Returns the portion of string specified by the start 0.
$string = Strings::substr('SG-1 returns from an off-world mission to P9Y-3C3', 0);

// Returns the portion of string specified by the start 0 and length 4.
$string = Strings::substr('SG-1 returns from an off-world mission to P9Y-3C3', 0, 4);
```

#### <a name="strings_ucfirst"></a> Method: `Strings::ucfirst()`

Converts the first character of a string to upper case and leaves the other characters unchanged.

```php
$string = Strings::ucfirst('daniel');
```

#### <a name="strings_trim"></a> Method: `Strings::trim()`

Strip whitespace (or other characters) from the beginning and end of a string.

```php
$string = Strings::trim(' daniel ');
```

#### <a name="strings_capitalize"></a> Method: `Strings::capitalize()`

Converts the first character of every word of string to upper case and the others to lower case.

```php
$string = Strings::capitalize('that country was at the same stage of development as the United States in the 1940s');
```

### License
[The MIT License (MIT)](https://github.com/flextype-components/strings/blob/master/LICENSE.txt)
Copyright (c) 2020 [Sergey Romanenko](https://github.com/Awilum)

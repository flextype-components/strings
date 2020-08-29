<?php

declare(strict_types=1);

namespace Flextype\Component\Strings;

use function ctype_lower;
use function implode;
use function lcfirst;
use function mb_strimwidth;
use function mb_strlen;
use function mb_strpos;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_strwidth;
use function mb_substr;
use function preg_match;
use function preg_replace;
use function random_int;
use function rtrim;
use function str_replace;
use function trim;
use function ucwords;

class Strings
{
    /**
     * The cache for words.
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * Removes any leading and traling slashes from a string.
     *
     * @param  string $string String with slashes
     */
    public static function trimSlashes(string $string): string
    {
        return trim($string, '/');
    }

    /**
     * Reduces multiple slashes in a string to single slashes.
     *
     * @param  string $string String or array of strings with slashes
     */
    public static function reduceSlashes(string $string): string
    {
        return preg_replace('#(?<!:)//+#', '/', $string);
    }

    /**
     * Removes single and double quotes from a string.
     *
     * @param  string $str String with single and double quotes
     */
    public static function stripQuotes(string $string): string
    {
        return str_replace(['"', "'"], '', $string);
    }

    /**
     * Convert single and double quotes to entities.
     *
     * @param  string $string String with single and double quotes
     */
    public static function quotesToEntities(string $string): string
    {
        return str_replace(["\'", '"', "'", '"'], ['&#39;', '&quot;', '&#39;', '&quot;'], $str);
    }

    /**
     * Creates a random string of characters.
     *
     * @param  int    $length   The number of characters. Default is 16
     * @param  string $keyspace The keyspace
     */
    public static function random(int $length = 64, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        if ($length <= 0) {
            $length = 1;
        }

        $pieces = [];
        $max    = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }

    /**
     * Add's _1 to a string or increment the ending number to allow _2, _3, etc.
     *
     * @param  string $string    String to increment
     * @param  int    $first     Start with
     * @param  string $separator Separator
     */
    public static function increment(string $string, int $first = 1, string $separator = '_'): string
    {
        preg_match('/(.+)' . $separator . '([0-9]+)$/', $string, $match);

        return isset($match[2]) ? $match[1] . $separator . ($match[2] + 1) : $string . $separator . $first;
    }

    /**
     * Return the length of the given string.
     *
     * @param  string      $string   String to check
     * @param  string|null $encoding String encoding
     */
    public static function length(string $string, ?string $encoding = null): int
    {
        if ($encoding) {
            return mb_strlen($string, $encoding);
        }

        return mb_strlen($string);
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param  string $string String
     * @param  int    $limit  Limit of characters
     * @param  string $append Text to append to the string IF it gets truncated
     */
    public static function limit(string $string, int $limit = 100, string $append = '...'): string
    {
        if (mb_strwidth($string, 'UTF-8') <= $limit) {
            return $string;
        }

        return rtrim(mb_strimwidth($string, 0, $limit, '', 'UTF-8')) . $append;
    }

    /**
     * Convert the given string to lower-case.
     *
     * @param  string $string String
     */
    public static function lower(string $string): string
    {
        return mb_strtolower($string, 'UTF-8');
    }

    /**
     * Convert the given string to upper-case.
     *
     * @param  string $value
     */
    public static function upper(string $string): string
    {
        return mb_strtoupper($string, 'UTF-8');
    }

    /**
     * Returns the portion of string specified by the start and length parameters.
     *
     * @param  string   $string The string to extract the substring from.
     * @param  int      $start  If start is non-negative, the returned string will
     *                          start at the start'th position in $string, counting from zero.
     *                          For instance, in the string 'abcdef', the character at position
     *                          0 is 'a', the character at position 2 is 'c', and so forth.
     * @param  int|null $length Maximum number of characters to use from string.
     *                          If omitted or NULL is passed, extract all characters to the end of the string.
     */
    public static function substr(string $string, int $start, ?int $length = null): string
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * Convert a string to studly caps case.
     *
     * @param  string $string String
     */
    public static function studly(string $string): string
    {
        $key = $string;

        if (isset(static::$cache['studly'][$key])) {
            return static::$cache['studly'][$key];
        }

        $string = ucwords(str_replace(['-', '_'], ' ', $string));

        return static::$cache['studly'][$key] = str_replace(' ', '', $string);
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string $string    String
     * @param  string $delimiter Delimeter
     */
    public static function snake(string $string, string $delimiter = '_'): string
    {
        $key = $string;

        if (isset(static::$cache['snake'][$key][$delimiter])) {
            return static::$cache['snake'][$key][$delimiter];
        }

        if (! ctype_lower($string)) {
            $value = preg_replace('/\s+/u', '', ucwords($string));

            $string = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $string));
        }

        return static::$cache['snake'][$key][$delimiter] = $string;
    }

    /**
     * Convert a string to camel case.
     *
     * @param  string $string String
     */
    public static function camel(string $string): string
    {
        if (isset(static::$cache['camel'][$string])) {
            return static::$cache['camel'][$string];
        }

        return static::$cache['camel'][$string] = lcfirst(static::studly($string));
    }

    /**
     * Convert a string to kebab case.
     *
     * @param  string $string String
     */
    public static function kebab(string $string): string
    {
        return static::snake($string, '-');
    }

    /**
     * Limit the number of words in a string.
     *
     * @param  string $string String
     * @param  int    $words  Words limit
     * @param  string $append Text to append to the string IF it gets truncated
     */
    public static function words(string $string, int $words = 100, string $append = '...'): string
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $string, $matches);

        if (! isset($matches[0]) || static::length($string) === static::length($matches[0])) {
            return $string;
        }

        return rtrim($matches[0]) . $append;
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string          $haystack The string being checked.
     * @param  string|string[] $needles  The string to find in haystack.
     */
    public static function contains(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}

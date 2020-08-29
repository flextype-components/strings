<?php

declare(strict_types=1);

namespace Flextype\Component\Strings;

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
     * @return string
     */
    public static function trimSlashes(string $string) : string
    {
        return trim($string, '/');
    }

    /**
     * Reduces multiple slashes in a string to single slashes.
     *
     * @param  string $string String or array of strings with slashes
     * @return string
     */
    public static function reduceSlashes(string $string) : string
    {
        return preg_replace('#(?<!:)//+#', '/', $string);
    }

    /**
     * Removes single and double quotes from a string.
     *
     * @param  string $str String with single and double quotes
     * @return string
     */
    public static function stripQuotes(string $string) : string
    {
        return str_replace(array('"', "'"), '', $string);
    }

    /**
     * Convert single and double quotes to entities.
     *
     * @param  string $string String with single and double quotes
     * @return string
     */
    public static function quotesToEntities(string $string) : string
    {
        return str_replace(array("\'", "\"", "'", '"'), array("&#39;", "&quot;", "&#39;", "&quot;"), $str);
    }

    /**
     * Creates a random string of characters.
     *
     * @param  int    $length   The number of characters. Default is 16
     * @param  string $keyspace The keyspace
     * @return string
     */
    public static function random(int $length = 64, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') : string
    {
        if ($length <= 0) {
            $length = 1;
        }

        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }

    /**
     * Add's _1 to a string or increment the ending number to allow _2, _3, etc.
     *
     * @param  string  $string    String to increment
     * @param  int     $first     Start with
     * @param  string  $separator Separator
     * @return string
     */
    public static function increment(string $string, int $first = 1, string $separator = '_') : string
    {
        preg_match('/(.+)'. $separator . '([0-9]+)$/', $string, $match);

        return isset($match[2]) ? $match[1] . $separator.($match[2] + 1) : $string . $separator . $first;
    }

    /**
     * Return the length of the given string.
     *
     * @param  string       $string   String to check
     * @param  string|null  $encoding String encoding
     * @return int
     */
    public static function length(string $string, $encoding = null) : int
    {
        if ($encoding) {
            return mb_strlen($string, $encoding);
        }

        return mb_strlen($string);
    }

    /**
      * Limit the number of characters in a string.
      *
      * @param  string  $string String
      * @param  int     $limit  Limit of characters
      * @param  string  $append Text to append to the string IF it gets truncated
      * @return string
      */
    public static function limit(string $string, int $limit = 100, string $append = '...') : string
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
     * @return string
     */
    public static function lower(string $string) : string
    {
        return mb_strtolower($string, 'UTF-8');
    }

    /**
     * Convert the given string to upper-case.
     *
     * @param  string  $value
     * @return string
     */
    public static function upper(string $string) : string
    {
        return mb_strtoupper($string, 'UTF-8');
    }

    /**
     * Convert a string to studly caps case.
     *
     * @param  string  $string String
     * @return string
     */
    public static function studly(string $string) : string
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
     * @param  string  $string    String
     * @param  string  $delimiter Delimeter
     * @return string
     */
    public static function snake(string $string, string $delimiter = '_') : string
    {
        $key = $string;

        if (isset(static::$cache['snake'][$key][$delimiter])) {
            return static::$cache['snake'][$key][$delimiter];
        }

        if (! ctype_lower($string)) {
            $value = preg_replace('/\s+/u', '', ucwords($string));

            $string = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $string));
        }

        return static::$cache['snake'][$key][$delimiter] = $string;
    }

    /**
     * Convert a string to camel case.
     *
     * @param  string  $string String
     * @return string
     */
    public static function camel($string)
    {
        if (isset(static::$cache['camel'][$string])) {
            return static::$cache['camel'][$string];
        }

        return static::$cache['camel'][$string] = lcfirst(static::studly($string));
    }

    /**
     * Convert a string to kebab case.
     *
     * @param  string  $string String
     * @return string
     */
    public static function kebab($string)
    {
        return static::snake($string, '-');
    }
}

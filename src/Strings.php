<?php

declare(strict_types=1);

namespace Flextype\Component\Strings;

class Strings
{
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

}

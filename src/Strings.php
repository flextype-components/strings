<?php

declare(strict_types=1);

namespace Flextype\Component\Strings;

use function abs;
use function array_reverse;
use function array_shift;
use function ctype_lower;
use function explode;
use function hash;
use function hash_algos;
use function htmlspecialchars;
use function htmlspecialchars_decode;
use function implode;
use function in_array;
use function lcfirst;
use function ltrim;
use function mb_convert_case;
use function mb_strimwidth;
use function mb_strlen;
use function mb_strpos;
use function mb_strrpos;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_strwidth;
use function mb_substr;
use function preg_match;
use function preg_quote;
use function preg_replace;
use function random_int;
use function rtrim;
use function str_pad;
use function str_replace;
use function str_word_count;
use function strlen;
use function strncmp;
use function strpos;
use function strrpos;
use function substr;
use function substr_replace;
use function trim;
use function ucwords;

use const ENT_IGNORE;
use const ENT_NOQUOTES;
use const MB_CASE_TITLE;
use const STR_PAD_BOTH;
use const STR_PAD_LEFT;
use const STR_PAD_RIGHT;

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
        return static::trim($string, '/');
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
        return str_replace(["\'", '"', "'", '"'], ['&#39;', '&quot;', '&#39;', '&quot;'], $string);
    }

    /**
     * Removes all invalid UTF-8 characters from a string.
     *
     * @param  string $string String
     */
    public static function fixEncoding(string $string): string
    {
        return htmlspecialchars_decode(htmlspecialchars($string, ENT_NOQUOTES | ENT_IGNORE, 'UTF-8'), ENT_NOQUOTES);
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
        $max    = static::length($keyspace, '8bit') - 1;

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
            $string = preg_replace('/\s+/u', '', ucwords($string));

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

        return static::trimRight($matches[0]) . $append;
    }

    /**
     * Return information about words used in a string
     *
     * @param  string $string   String
     * @param  int    $format   Specify the return value of this function. The current supported values are:
     *                          0 - returns the number of words found
     *                          1 - returns an array containing all the words found inside the string
     *                          2 - returns an associative array, where the key is the numeric position of the word inside the string and the value is the actual word itself
     * @param  string $charlist A list of additional characters which will be considered as 'word'
     */
    public static function wordsCount(string $string, int $format = 0, string $charlist = '')
    {
        return str_word_count($string, $format, $charlist);
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

    /**
     * Determine if a given string contains all array values.
     *
     * @param  string   $haystack The string being checked.
     * @param  string[] $needles  The array of strings to find in haystack.
     */
    public static function containsAll(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (! static::contains($haystack, $needle)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if a given string contains any of array values.
     *
     * @param  string   $haystack The string being checked.
     * @param  string[] $needles  The array of strings to find in haystack.
     */
    public static function containsAny(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (static::contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Converts the first character of a string to upper case
     * and leaves the other characters unchanged.
     *
     * @param  string $string String
     */
    public static function ucfirst(string $string): string
    {
        return static::upper(static::substr($string, 0, 1)) . static::substr($string, 1);
    }

    /**
     * Converts the first character of every word of string to upper case and the others to lower case.
     *
     * @param  string $string String
     */
    public static function capitalize(string $string): string
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Strip whitespace (or other characters) from the beginning and end of a string.
     *
     * @param string $string         The string that will be trimmed.
     * @param string $character_mask Optionally, the stripped characters can also be
     *                               specified using the character_mask parameter..
     */
    public static function trim(string $string, string $character_mask = " \t\n\r\0\x0B"): string
    {
        return trim($string, $character_mask);
    }

    /**
     * Strip whitespace (or other characters) from the beginning of a string.
     *
     * @param string $string         The string that will be trimmed.
     * @param string $character_mask Optionally, the stripped characters can also be
     *                               specified using the character_mask parameter..
     */
    public static function trimLeft(string $string, string $character_mask = " \t\n\r\0\x0B"): string
    {
        return ltrim($string, $character_mask);
    }

    /**
     * Strip whitespace (or other characters) from the end of a string.
     *
     * @param string $string         The string that will be trimmed.
     * @param string $character_mask Optionally, the stripped characters can also be
     *                               specified using the character_mask parameter..
     */
    public static function trimRight(string $string, string $character_mask = " \t\n\r\0\x0B"): string
    {
        return rtrim($string, $character_mask);
    }

    /**
     * Reverses string.
     *
     * @param  string $string String
     */
    public static function reverse(string $string): string
    {
        $result = '';

        for ($i = static::length($string); $i >= 0; $i--) {
            $result .= static::substr($string, $i, 1);
        }

        return $result;
    }

    /**
     * Get array of segments from a string based on a delimiter.
     *
     * @param string $string    String
     * @param string $delimiter Delimeter
     */
    public static function segments(string $string, string $delimiter = ' '): array
    {
        return explode($delimiter, $string);
    }

    /**
     * Get a segment from a string based on a delimiter.
     * Returns an empty string when the offset doesn't exist.
     * Use a negative index to start counting from the last element.
     *
     * @param string $string    String
     * @param int    $index     Index
     * @param string $delimiter Delimeter
     */
    public static function segment(string $string, int $index, string $delimiter = ' '): string
    {
        $segments = explode($delimiter, $string);

        if ($index < 0) {
            $segments = array_reverse($segments);
            $index    = abs($index) - 1;
        }

        return $segments[$index] ?? '';
    }

    /**
     * Get the first segment from a string based on a delimiter.
     *
     * @param string $string    String
     * @param string $delimiter Delimeter
     */
    public static function firstSegment(string $string, string $delimiter = ' '): string
    {
        return static::segment($string, 0, $delimiter);
    }

    /**
     * Get the last segment from a string based on a delimiter.
     *
     * @param string $string    String
     * @param string $delimiter Delimeter
     */
    public static function lastSegment(string $string, string $delimiter = ' '): string
    {
        return static::segment($string, -1, $delimiter);
    }

    /**
     * Get the portion of a string before the first occurrence of a given value.
     *
     * @param string $string String
     * @param string $search Search
     */
    public static function before(string $string, string $search): string
    {
        return $search === '' ? $string : explode($search, $string)[0];
    }

    /**
     * Get the portion of a string before the last occurrence of a given value.
     *
     * @param string $string String
     * @param string $search Search
     */
    public static function beforeLast(string $string, string $search): string
    {
        if ($search === '') {
            return $string;
        }

        $position = mb_strrpos($string, $search);

        if ($position === false) {
            return $string;
        }

        return static::substr($string, 0, $position);
    }

    /**
     * Return the remainder of a string after the first occurrence of a given value.
     *
     * @param string $string String
     * @param string $search Search
     */
    public static function after(string $string, string $search): string
    {
        return $search === '' ? $string : array_reverse(explode($search, $string, 2))[0];
    }

    /**
     * Return the remainder of a string after the last occurrence of a given value.
     *
     * @param string $string String
     * @param string $search Search
     */
    public static function afterLast(string $string, string $search): string
    {
        if ($search === '') {
            return $string;
        }

        $position = mb_strrpos($string, (string) $search);

        if ($position === false) {
            return $string;
        }

        return static::substr($string, $position + static::length($search));
    }

    /**
     * Pad both sides of a string with another.
     *
     * @param  string $string The input string.
     * @param  int    $length If the value of pad_length is negative, less than, or equal to the length of the input string, no padding takes place, and input will be returned.
     * @param  string $pad    The pad string may be truncated if the required number of padding characters can't be evenly divided by the pad_string's length.
     */
    public static function padBoth(string $string, int $length, string $pad = ' '): string
    {
        return str_pad($string, $length, $pad, STR_PAD_BOTH);
    }

    /**
     * Pad the left side of a string with another.
     *
     * @param  string $string The input string.
     * @param  int    $length If the value of pad_length is negative, less than, or equal to the length of the input string, no padding takes place, and input will be returned.
     * @param  string $pad    The pad string may be truncated if the required number of padding characters can't be evenly divided by the pad_string's length.
     */
    public static function padLeft(string $string, int $length, string $pad = ' '): string
    {
        return str_pad($string, $length, $pad, STR_PAD_LEFT);
    }

    /**
     * Pad the right side of a string with another.
     *
     * @param  string $string The input string.
     * @param  int    $length If the value of pad_length is negative, less than, or equal to the length of the input string, no padding takes place, and input will be returned.
     * @param  string $pad    The pad string may be truncated if the required number of padding characters can't be evenly divided by the pad_string's length.
     */
    public static function padRight(string $string, int $length, string $pad = ' '): string
    {
        return str_pad($string, $length, $pad, STR_PAD_RIGHT);
    }

    /**
     * Strip all whitespaces from the given string.
     *
     * @param string $string The string to strip
     */
    public static function stripSpaces(string $string): string
    {
        return preg_replace('/\s+/', '', $string);
    }

    /**
     * Replace a given value in the string sequentially with an array.
     *
     * @param  string $string  String
     * @param  string $search  Search
     * @param  array  $replace Replace
     */
    public static function replaceArray(string $string, string $search, array $replace): string
    {
        $segments = explode($search, $string);

        $result = array_shift($segments);

        foreach ($segments as $segment) {
            $result .= (array_shift($replace) ?? $search) . $segment;
        }

        return $result;
    }

    /**
     * Replace the first occurrence of a given value in the string.
     *
     * @param  string $string  String
     * @param  string $search  Search
     * @param  string $replace Replace
     */
    public static function replaceFirst(string $string, string $search, string $replace): string
    {
        if ($search === '') {
            return $string;
        }

        $position = strpos($string, $search);

        if ($position !== false) {
            return substr_replace($string, $replace, $position, strlen($search));
        }

        return $search;
    }

    /**
     * Replace the last occurrence of a given value in the string.
     *
     * @param  string $string  String
     * @param  string $search  Search
     * @param  string $replace Replace
     */
    public static function replaceLast(string $string, string $search, string $replace): string
    {
        $position = strrpos($string, $search);

        if ($position !== false) {
            return substr_replace($string, $replace, $position, strlen($search));
        }

        return $subject;
    }

    /**
     * Begin a string with a single instance of a given value.
     *
     * @param  string $string String
     * @param  string $prefix Prefix
     */
    public static function start(string $string, string $prefix): string
    {
        $quoted = preg_quote($prefix, '/');

        return $prefix . preg_replace('/^(?:' . $quoted . ')+/u', '', $string);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string          $haystack Haystack
     * @param  string|string[] $needles  needles
     */
    public static function startsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string          $haystack Haystack
     * @param  string|string[] $needles  needles
     */
    public static function endsWith(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string $string String
     * @param  string $cap    Cap
     */
    public static function finish(string $string, string $cap): string
    {
        $quoted = preg_quote($cap, '/');

        return preg_replace('/(?:' . $quoted . ')+$/u', '', $string) . $cap;
    }

    /**
     * Generate a hash string from the input string.
     *
     * @param  string $string     String
     * @param  string $algorithm  Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..).
     *                            For a list of supported algorithms see hash_algos(). Default is md5.
     * @param  string $raw_output When set to TRUE, outputs raw binary data. FALSE outputs lowercase hexits. Default is FALSE
     */
    public static function hash(string $string, string $algorithm = 'md5', bool $raw_output = false): string
    {
        if (in_array($algorithm, hash_algos())) {
            return hash($algorithm, $string, $raw_output);
        }

        return $string;
    }
}

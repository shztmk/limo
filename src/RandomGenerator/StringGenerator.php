<?php declare(strict_types=1);

namespace Limo\RandomGenerator;

use Exception;
use RangeException;
use RuntimeException;

/**
 * @package Test\Util
 */
final class StringGenerator
{
    /**
     * Characters that may be used in the generated random string.
     * @TODO Move to the configuration file.
     * @var string
     */
    public const KEY_SPACE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param string $keyspace
     * @return int
     */
    final public static function strlen(string $keyspace): int
    {
        $length = grapheme_strlen($keyspace);
        if (is_int($length)) {
            return $length;
        }

        throw new RuntimeException(sprintf(
            'Something wrong happened at grapheme_strlen. $keyspace:%s',
            $keyspace
        ));
    }

    /**
     * @param string $keyspace
     * @param int $offset
     * @return string
     */
    final public static function substr(string $keyspace, int $offset): string
    {
        $string = grapheme_substr($keyspace, $offset, 1);
        if (is_string($string)) {
            return $string;
        }

        throw new RuntimeException(sprintf(
            'Something wrong happened at grapheme_substr. $keyspace:%s, $offset:%d',
            $keyspace,
            $offset
        ));
    }

    /**
     * Returns a random string.
     * @see https://stackoverflow.com/a/31107425
     * @see https://www.php.net/manual/en/function.random-int.php
     * @param int $length
     * @param string $keyspace
     * @param bool $isEmptyAllowed
     * @return string
     * @throws Exception
     */
    final public static function generate(
        int    $length,
        string $keyspace = self::KEY_SPACE,
        bool   $isEmptyAllowed = false
    ): string
    {
        if ($isEmptyAllowed === false && $length < 1) {
            throw new RangeException('The specified $length of string is not a positive number.');
        }

        $pieces = [];
        $max = self::strlen($keyspace);

        for ($i = 0; $i < $length; ++$i) {
            $offset = random_int(0, $max - 1);
            $pieces[] = self::substr($keyspace, $offset);
        }

        return implode('', $pieces);
    }
}
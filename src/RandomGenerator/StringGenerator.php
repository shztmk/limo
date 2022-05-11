<?php declare(strict_types=1);

namespace Limo\RandomGenerator;

use Exception;
use RangeException;

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
    private const KEY_SPACE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param string $keyspace
     * @return int
     */
    final public static function strlen(string $keyspace): int
    {
        return grapheme_strlen($keyspace);
    }

    /**
     * @param string $keyspace
     * @param int $offset
     * @return string
     */
    final public static function substr(string $keyspace, int $offset): string
    {
        return grapheme_substr($keyspace, $offset, 1);
    }

    /**
     * Returns a random string.
     * @see https://stackoverflow.com/a/31107425
     * @see https://www.php.net/manual/en/function.random-int.php
     * @param int $length
     * @param string $keyspace
     * @return string
     * @throws Exception
     */
    final public static function generate(
        int    $length,
        string $keyspace = self::KEY_SPACE
    ): string
    {
        if ($length < 1) {
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
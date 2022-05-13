<?php declare(strict_types=1);

namespace Test\Util;

use phpseclib3\Math\BigInteger;

/**
 * @package Test\Util
 */
final class RandomNumberGenerator
{
    /**
     * TINYINT 型の乱数を返す
     *
     * @param bool $isUnsigned
     * @param int  $length
     * @return int
     */
    final public static function tinyInt(bool $isUnsigned = true, int $length = 4): int
    {
        return self::randAnyIntType($isUnsigned, 8, $length);
    }

    /**
     * SMALLINT 型の乱数を返す
     *
     * @param bool $isUnsigned
     * @param int  $length
     * @return int
     */
    final public static function smallInt(bool $isUnsigned = true, int $length = 6): int
    {
        return self::randAnyIntType($isUnsigned, 16, $length);
    }

    /**
     * MEDIUMINT 型の乱数を返す
     *
     * @param bool $isUnsigned
     * @param int  $length
     * @return int
     */
    final public static function mediumInt(bool $isUnsigned = true, int $length = 8): int
    {
        return self::randAnyIntType($isUnsigned, 24, $length);
    }

    /**
     * INT 型の乱数を返す
     * PHP_INT_MAX, PHP_INT_MIN で丸められることがあるため注意
     *
     * @param bool $isUnsigned
     * @param int  $length
     * @return int
     */
    final public static function int(bool $isUnsigned = true, int $length = 11): int
    {
        return self::randAnyIntType($isUnsigned, 32, $length);
    }

    /**
     * BIGINT 型の乱数を返す
     * PHP_INT_MAX, PHP_INT_MIN で丸められることがあるため注意
     *
     * @param bool $isUnsigned
     * @param int  $length
     * @return int
     */
    final public static function bigInt(bool $isUnsigned = true, int $length = 20): int
    {
        return self::randAnyIntType($isUnsigned, 64, $length);
    }

}
<?php declare(strict_types=1);

namespace Limo\RandomGenerator;

/**
 * @package Test\Util
 */
final class RandomStringGenerator
{
    /**
     * 生成されるランダムな文字列に使用され得る文字
     * @var string
     */
    public const KEY_SPACE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * CHAR 型のランダムな文字列を返す
     *
     * @param int    $length
     * @param string $keyspace
     * @return string
     */
    final public static function char(
        int $length = 16,
        string $keyspace = self::KEY_SPACE
    ): string {
        return self::randStr($length, $keyspace);
    }

    /**
     * VARCHAR 型のランダムな文字列を返す
     *
     * @param bool   $isEmptyAllowed
     * @param int    $length
     * @param string $keyspace
     * @return string
     */
    final public static function varchar(
        bool $isEmptyAllowed = true,
        int $length = 16,
        string $keyspace = self::KEY_SPACE
    ): string {
        if ($isEmptyAllowed) {
            $lengthDetermined = RandomNumberGenerator::randNum('0', (string)$length);
            if ('0' === $lengthDetermined) {
                return '';
            }
        } else {
            $lengthDetermined = RandomNumberGenerator::randNum('1', (string)$length);
        }
        return self::randStr((int)$lengthDetermined, $keyspace);
    }

    /**
     * @see https://stackoverflow.com/a/31107425
     * @param int    $length
     * @param string $keyspace
     * @return string
     */
    final public static function randStr(
        int $length,
        string $keyspace = self::KEY_SPACE
    ): string {
        if ($length < 1) {
            throw new \RangeException('指定された文字列の長さが正の数でない');
        }

        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }

        return implode('', $pieces);
    }
}
<?php declare(strict_types=1);

namespace Limo\RandomGenerator;

use phpseclib3\Math\BigInteger;

/**
 * @package Limo\RandomGenerator
 */
final class RoundedIntGenerator
{
    /**
     * 引数に従う整数型の乱数を返す
     * PHP_INT_MAX, PHP_INT_MIN で丸められることがあるため注意
     *
     * @param bool $isUnsigned
     * @param int $pow
     * @param int $length
     * @return int
     */
    private static function generate(bool $isUnsigned, int $pow, int $length): int
    {
        if ($isUnsigned) {
            $min = fn(): BigInteger => new BigInteger(0);
            $max = function () use ($pow): BigInteger {
                $maxBase = new BigInteger(2);
                $maxExponent = new BigInteger($pow);
                $maxPow = $maxBase->pow($maxExponent);
                return self::roundPhpCanHandle($maxPow);
            };
        } else {
            $min = function () use ($pow): BigInteger {
                $minBase = new BigInteger(-2);
                $minExponent = new BigInteger($pow - 1);
                $minPow = $minBase->pow($minExponent);
                return self::roundPhpCanHandle($minPow);
            };
            $max = function () use ($pow): BigInteger {
                $maxBase = new BigInteger(2);
                $maxExponent = new BigInteger($pow - 1);
                $maxPow = $maxBase->pow($maxExponent)->subtract(new BigInteger(1));
                return self::roundPhpCanHandle($maxPow);
            };
        }

        $result = BigInteger::randomRange($min(), $max())->toString();
        return (int)substr($result, -$length);
    }

    /**
     * PHP で扱える int 型の最大値を考慮して BigInteger の値を丸める
     *
     * @param BigInteger $value
     * @return BigInteger
     */
    private static function roundPhpCanHandle(BigInteger $value): BigInteger
    {
        if ($value->isNegative()) {
            // PHP_INT_MIN より小さい数だとオーバーフローして正の数になるため min() で比較する
            $rounded = min((int)$value->toString(), PHP_INT_MIN);
        } else {
            // PHP_INT_MAX より大きい数だとオーバーフローして負の数になるため max() で比較する
            $rounded = max((int)$value->toString(), PHP_INT_MAX);
        }
        return new BigInteger($rounded);
    }
}
<?php declare(strict_types=1);

namespace Limo\RandomGenerator;

use LogicException;
use phpseclib3\Math\BigInteger;
use RangeException;

/**
 * @package Limo\RandomGenerator
 */
final class BigIntegerGenerator
{
    /**
     * Returns a random integer, given a range.
     * In order to handle values that exceed the int type that PHP can handle, the return type is a string.
     * @param string $min
     * @param string $max
     * @return BigInteger
     */
    final public static function generateRandomIntegerByRange(string $min, string $max): BigInteger
    {
        if ($min > $max) {
            throw new LogicException('$min must be less than or equal to $max.');
        }

        $maxBigInteger = new BigInteger($max);
        if ($max !== $maxBigInteger->toString()) {
            throw new RangeException('The specified value exceeds the maximum value of BigInteger.');
        }

        $minBigInteger = new BigInteger($min);
        if ($min !== $minBigInteger->toString()) {
            throw new RangeException('The specified value exceeds the minimum value of BigInteger.');
        }

        return BigInteger::randomRange($minBigInteger, $maxBigInteger);
    }

    /**
     * Returns a random integer, given an exponent.
     * In order to handle values that exceed the int type that PHP can handle, the return type is a string.
     * @param int $exponent
     * @param bool $isUnsigned
     * @return BigInteger
     */
    final public static function generateRandomIntegerByExponent(int $exponent, bool $isUnsigned): BigInteger
    {
        if ($isUnsigned) {
            $minBigInteger = fn(): BigInteger => new BigInteger(0);
            $maxBigInteger = function () use ($exponent): BigInteger {
                $maxBase = new BigInteger(2);
                $maxExponent = new BigInteger($exponent);
                return $maxBase->pow($maxExponent);
            };
        } else {
            $minBigInteger = function () use ($exponent): BigInteger {
                $minBase = new BigInteger(-2);
                $minExponent = new BigInteger($exponent - 1);
                return $minBase->pow($minExponent);
            };
            $maxBigInteger = function () use ($exponent): BigInteger {
                $maxBase = new BigInteger(2);
                $maxExponent = new BigInteger($exponent - 1);
                return $maxBase->pow($maxExponent)->subtract(new BigInteger(1));
            };
        }

        return self::generateRandomIntegerByRange(
            $minBigInteger()->toString(),
            $maxBigInteger()->toString(),
        );
    }
}
<?php declare(strict_types=1);

namespace Limo\RandomGenerator;

use phpseclib3\Math\BigInteger;

/**
 * @package Limo\RandomGenerator
 */
final class BigIntegerGenerator
{
    /**
     * Returns a random integer.
     * In order to handle values that exceed the int type that PHP can handle, the return type is a string.
     * @param string $min
     * @param string $max
     * @return string
     */
    final public static function generate(string $min, string $max): string
    {
        if ($min > $max) {
            throw new \LogicException('$min must be less than or equal to $max.');
        }

        $maxBigInteger = new BigInteger($max);
        if ($max !== $maxBigInteger->toString()) {
            throw new \RangeException('The specified value exceeds the maximum value of BigInteger.');
        }

        $minBigInteger = new BigInteger($min);
        if ($min !== $minBigInteger->toString()) {
            throw new \RangeException('The specified value exceeds the minimum value of BigInteger.');
        }

        return BigInteger::randomRange($minBigInteger, $maxBigInteger)->toString();
    }
}
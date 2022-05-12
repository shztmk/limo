<?php declare(strict_types=1);

namespace Test\RandomGenerator;

use Limo\RandomGenerator\BigIntegerGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Limo\RandomGenerator\BigIntegerGenerator
 */
class BigIntegerGeneratorTest extends TestCase
{
    /**
     * @covers ::generateRandomIntegerByRange
     * @return void
     */
    final public function testGenerateIfMinIsGreaterThanMax(): void
    {
        self::expectException(\LogicException::class);
        self::expectErrorMessage('$min must be less than or equal to $max.');
        BigIntegerGenerator::generateRandomIntegerByRange('10', '0');
    }
}
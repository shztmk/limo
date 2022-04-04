<?php declare(strict_types=1);

namespace Test\MemorizedInvoker;

use Limo\RandomGenerator\BigIntegerGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Limo\RandomGenerator\BigIntegerGenerator
 */
class BigIntegerGeneratorTest extends TestCase
{
    /**
     * @covers ::generate
     * @return void
     */
    final public function testGenerateIfMinIsGreaterThanMax(): void
    {
        self::expectException(\LogicException::class);
        self::expectErrorMessage('$min must be less than or equal to $max.');
        BigIntegerGenerator::generate('10', '0');
    }
}
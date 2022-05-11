<?php declare(strict_types=1);

namespace Test\RandomGenerator;

use Exception;
use Limo\RandomGenerator\StringGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Limo\RandomGenerator\StringGenerator
 */
class StringGeneratorTest extends TestCase
{
    /**
     * @covers ::generate
     * @return void
     * @throws Exception
     */
    final public function testGenerate(): void
    {
        for ($i = 0; $i < 50; ++$i) {
            $length = 5;
            $result = StringGenerator::generate(
                $length,
                '0123456789０１２３４５６７８９零壱弐参肆伍陸漆捌玖0️⃣1️⃣2️⃣3️⃣4️⃣5️⃣6️⃣7️⃣8️⃣9️⃣󠁧󠁢󠁥󠁮󠁧󠁿󠁧󠁢󠁥󠁮󠁧󠁿'
            );
            self::assertSame($length, StringGenerator::strlen($result));
        }
    }
}
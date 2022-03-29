<?php declare(strict_types=1);

namespace Test;

use Limo\Example;
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    final public function testInvoke(): void
    {
        $example = new Example();
        self::assertSame('example', $example->__invoke());
    }
}
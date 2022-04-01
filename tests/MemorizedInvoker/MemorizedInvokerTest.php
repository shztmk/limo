<?php declare(strict_types=1);

namespace Test\MemorizedInvoker;

use Limo\MemorizedInvoker\MemorizedInvoker;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Limo\MemorizedInvoker\MemorizedInvoker
 */
final class MemorizedInvokerTest extends TestCase
{
    /**
     * @dataProvider returnUniqIntIfExceededLimitDataProvider
     * @covers ::returnUniq
     * @param callable $toInvoke
     * @param int $maxRetryCount
     * @return void
     */
    final public function testReturnUniqIntIfExceededLimit(callable $toInvoke, int $maxRetryCount): void
    {
        self::expectException(\RuntimeException::class);
        self::expectErrorMessage('The number of attempts to generate a unique INTEGER has exceeded the limit.');
        $invoker = new MemorizedInvoker($maxRetryCount);
        $invoker->returnUniq($toInvoke, 'integer');
        $invoker->returnUniq($toInvoke, 'integer');
    }

    /**
     * @return array
     */
    private function returnUniqIntIfExceededLimitDataProvider(): array
    {
        return [
            [
                function () {
                    static $arr = [0, 0];
                    return array_shift($arr);
                },
                1,
            ], [
                function () {
                    static $arr = [1, 1, 1];
                    return array_shift($arr);
                },
                2,
            ], [
                function () {
                    static $arr = [-1, -1, -1, -1];
                    return array_shift($arr);
                },
                3,
            ]
        ];
    }

    /**
     * @dataProvider returnUniqStringIfExceededLimitDataProvider
     * @covers ::returnUniq
     * @param callable $toInvoke
     * @param int $maxRetryCount
     * @return void
     */
    final public function testReturnUniqStringIfExceededLimit(callable $toInvoke, int $maxRetryCount): void
    {
        self::expectException(\RuntimeException::class);
        $invoker = new MemorizedInvoker($maxRetryCount);
        $invoker->returnUniq($toInvoke, 'string');
        $invoker->returnUniq($toInvoke, 'string');
    }

    /**
     * @return array
     */
    private function returnUniqStringIfExceededLimitDataProvider(): array
    {
        return [
            [
                function () {
                    static $arr = ['', ''];
                    return array_shift($arr);
                },
                1,
            ], [
                function () {
                    static $arr = ['🍣', '🍣', '🍣'];
                    return array_shift($arr);
                },
                2,
            ], [
                function () {
                    static $arr = ['🍥', '🍥', '🍥', '🍥'];
                    return array_shift($arr);
                },
                3,
            ],
        ];
    }
}
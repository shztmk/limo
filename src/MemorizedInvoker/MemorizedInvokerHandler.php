<?php declare(strict_types=1);

namespace Limo\MemorizedInvoker;

/**
 * @package Limo\MemorizedInvoker
 */
final class MemorizedInvokerHandler
{
    private MemorizedInvoker $memorizedInvoker;

    final public function __construct()
    {
        $this->memorizedInvoker = new MemorizedInvoker();
    }

    /**
     * Consider integer argument $generated as already generated and returned.
     * @param int $generated
     * @param bool $ignoreDuplicates
     * @return void
     */
    final public function considerIntAsGenerated(int $generated, bool $ignoreDuplicates = false): void
    {
        $this->memorizedInvoker->considerAsGenerated($generated, $ignoreDuplicates);
    }

    /**
     * Consider string argument $generated as already generated and returned.
     * @param string $generated
     * @param bool $ignoreDuplicates
     * @return void
     */
    final public function considerStringAsGenerated(string $generated, bool $ignoreDuplicates = false): void
    {
        $this->memorizedInvoker->considerAsGenerated($generated, $ignoreDuplicates);
    }

    /**
     * Invoke $toInvoke so that the return value is always unique.
     * The Return value of $toInvoke must be INTEGER.
     * @param callable $toInvoke fn() => int
     * @return int
     */
    final public function returnUniqInt(callable $toInvoke): int
    {
        return $this->memorizedInvoker->returnUniq($toInvoke, 'integer');
    }

    /**
     * Invoke $toInvoke so that the return value is always unique.
     * The Return value of $toInvoke must be STRING.
     * @param callable $toInvoke fn() => string
     * @return string
     */
    final public function returnUniqString(callable $toInvoke): string
    {
        return $this->memorizedInvoker->returnUniq($toInvoke, 'string');
    }
}
<?php declare(strict_types=1);

namespace Limo\MemorizedInvoker;

/**
 * @package Limo\MemorizedInvoker
 */
final class MemorizedInvokerHandler
{
    public const DEFAULT_OF_MAX_RETRY_COUNT = 3;
    private MemorizedInvoker $memorizedInvoker;

    final public function __construct(int $maxRetryCount = self::DEFAULT_OF_MAX_RETRY_COUNT)
    {
        $this->memorizedInvoker = new MemorizedInvoker($maxRetryCount);
    }

    /**
     * Consider integer argument $generated as already generated and returned.
     * @param string $generated
     * @param bool $ignoreDuplicates
     * @return void
     */
    final public function considerIntAsGenerated(string $generated, bool $ignoreDuplicates = false): void
    {
        $this->memorizedInvoker->considerAsGenerated($generated, $ignoreDuplicates, 'integer');
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
     * @param callable $toInvoke fn() => BigInteger
     * @return string
     */
    final public function returnUniqInt(callable $toInvoke): string
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
<?php declare(strict_types=1);

namespace Limo\MemorizedInvoker;

/**
 * @package Limo\MemorizedInvoker
 */
final class MemorizedInvoker
{
    /**
     * @param int $maxRetryCount
     */
    final public function __construct(int $maxRetryCount)
    {
        $this->maxRetryCount = $maxRetryCount;
    }

    /**
     * Number of attempts until a unique value appears when generated random values collide.
     * @var int
     */
    private int $maxRetryCount;

    /**
     * Array to store values generated and returned.
     * @var array
     */
    private array $generatedList = [];

    /**
     * Consider the argument $generated as already generated and returned.
     * @param mixed $generated
     * @param string $identifyKey
     * @param bool $ignoreDuplicates
     * @return void
     */
    final public function considerAsGenerated(
        mixed  $generated,
        string $identifyKey,
        bool   $ignoreDuplicates = false
    ): void
    {
        if (in_array($generated, $this->generatedList[$identifyKey], true)) {
            if ($ignoreDuplicates) {
                return;
            }
            throw new \RuntimeException(
                sprintf('%s argument $generated has already been generated and returned.', ucfirst($identifyKey))
            );
        }
        $this->generatedList[$identifyKey][] = $generated;
    }

    /**
     * Invoke $toInvoke so that the return value is always unique.
     * @param callable $toInvoke fn() => TReturn
     * @return mixed TReturn
     */
    final public function returnUniq(callable $toInvoke, string $identifyKey): mixed
    {
        for ($i = 1; $i <= $this->maxRetryCount; $i++) {
            $generated = $toInvoke();

            if (
                false === array_key_exists($identifyKey, $this->generatedList)
                || false === in_array($generated, $this->generatedList[$identifyKey], true)
            ) {
                $this->generatedList[$identifyKey][] = $generated;
                return $generated;
            }
        }
        throw new \RuntimeException(sprintf(
            'The number of attempts to generate a unique %s has exceeded the limit.',
            strtoupper($identifyKey)
        ));
    }
}
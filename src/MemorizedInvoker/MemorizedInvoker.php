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
     * @TODO Move to the configuration file.
     */
    private int $maxRetryCount;

    /**
     * Array to store values generated and returned.
     * @var array
     */
    private array $generatedList = [];

    /**
     * Consider the argument $generated as already generated and returned.
     * @see https://www.php.net/manual/ja/function.gettype.php
     * @param mixed $generated
     * @param bool $ignoreDuplicates
     * @param string|null $typeOfGenerated
     * @return void
     */
    final public function considerAsGenerated(
        mixed   $generated,
        bool    $ignoreDuplicates = false,
        ?string $typeOfGenerated = null
    ): void
    {
        $typeOfGenerated = $typeOfGenerated ?? gettype($generated);
        if (in_array($generated, $this->generatedList[$typeOfGenerated], true)) {
            if ($ignoreDuplicates) {
                return;
            }
            throw new \RuntimeException(
                sprintf('%s argument $generated has already been generated and returned.', ucfirst($typeOfGenerated))
            );
        }
        $this->generatedList[$typeOfGenerated][] = $generated;
    }

    /**
     * Invoke $toInvoke so that the return value is always unique.
     * @param callable $toInvoke fn() => TReturn
     * @return mixed TReturn
     */
    final public function returnUniq(callable $toInvoke, string $typeOfGenerated): mixed
    {
        for ($i = 1; $i <= $this->maxRetryCount; $i++) {
            $generated = $toInvoke();

            if (
                false === array_key_exists($typeOfGenerated, $this->generatedList)
                || false === in_array($generated, $this->generatedList[$typeOfGenerated], true)
            ) {
                $this->generatedList[$typeOfGenerated][] = $generated;
                return $generated;
            }
        }
        throw new \RuntimeException(sprintf(
            'The number of attempts to generate a unique %s has exceeded the limit.',
            strtoupper($typeOfGenerated)
        ));
    }
}
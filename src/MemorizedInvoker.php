<?php declare(strict_types=1);

namespace Limo;

/**
 * @package Limo
 */
final class MemorizedInvoker
{
    /**
     * @param int $maxRetryCount
     */
    final public function __construct(int $maxRetryCount = 3)
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
     * @param mixed $generated
     * @param bool $ignoreDuplicates
     * @return void
     */
    final public function considerAsGenerated(mixed $generated, bool $ignoreDuplicates = false): void
    {
        $typeOfGenerated = gettype($generated);
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
     * @param callable $toInvoke fn() => T
     * @return mixed T
     */
    final public function returnUniq(callable $toInvoke, string $typeOfGenerated): mixed
    {
        for ($i = 1; $i <= $this->maxRetryCount; $i++) {
            $generated = $toInvoke();

            if ($typeOfGenerated !== gettype($generated)) {
                throw new \RuntimeException(sprintf(
                    'Although we expected %s, invoker returned %s.',
                    $typeOfGenerated,
                    gettype($generated),
                ));
            }

            if (false === in_array($generated, $this->generatedList[$typeOfGenerated], true)) {
                $this->generatedList[$typeOfGenerated][] = $generated;
                return $generated;
            }
        }
        throw new \RuntimeException(sprintf(
            'The number of attempts to generate a unique %s has exceeded the limit.',
            strtoupper($typeOfGenerated ?? '')
        ));
    }
}
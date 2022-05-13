<?php declare(strict_types=1);

namespace Limo\MySql80;

use Limo\MemorizedInvoker\MemorizedInvokerHandler;
use Limo\RandomGenerator\BigIntegerGenerator;
use Limo\RandomGenerator\RandomStringGenerator;
use phpseclib3\Math\BigInteger;

/**
 * @see https://dev.mysql.com/doc/refman/8.0/en/data-types.html
 * @package Limo\MySql80
 */
final class LiteralMocker
{
    private MemorizedInvokerHandler $handler;
    private int $maxRetryCount;

    final public function __construct(
        int $maxRetryCount = MemorizedInvokerHandler::DEFAULT_OF_MAX_RETRY_COUNT
    )
    {
        $this->initialize($maxRetryCount);
    }

    /**
     * Initialize state. This is an alias of tearDown() or initialize().
     * @return void
     */
    final public function setUp(): void
    {
        $this->initialize($this->maxRetryCount);
    }

    /**
     * Initialize state. This is an alias of setUp() or initialize().
     * @return void
     */
    final public function tearDown(): void
    {
        $this->initialize($this->maxRetryCount);
    }

    /**
     * Initialize state. This is an alias of setUp() or tearDown().
     * @param int $maxRetryCount
     * @return void
     */
    final public function initialize(int $maxRetryCount = MemorizedInvokerHandler::DEFAULT_OF_MAX_RETRY_COUNT): void
    {
        $this->maxRetryCount = $maxRetryCount;
        $this->handler = new MemorizedInvokerHandler($maxRetryCount);
    }


    /**
     * 重複しない TINYINT 型の乱数を返す
     *
     * @param bool $isUnsigned
     * @param int $length
     * @return string
     */
    final public function tinyInt(bool $isUnsigned = true, int $length = 4): string
    {
        $invoker = function () use ($isUnsigned): string {
            return BigIntegerGenerator::generateRandomIntegerByExponent(8, $isUnsigned)
                ->toString();
        };
        return $this->handler->returnUniqInt($invoker);
    }

    /**
     * 重複しない SMALLINT 型の乱数を返す
     *
     * @param bool $isUnsigned
     * @param int $length
     * @return string
     */
    final public function smallInt(bool $isUnsigned = true, int $length = 6): string
    {
        $invoker = function () use ($isUnsigned): string {
            return BigIntegerGenerator::generateRandomIntegerByExponent(16, $isUnsigned)
                ->toString();
        };
        return $this->handler->returnUniqInt($invoker);
    }

    /**
     * 重複しない MEDIUMINT 型の乱数を返す
     *
     * @param bool $isUnsigned
     * @param int $length
     * @return string
     */
    final public function mediumInt(bool $isUnsigned = true, int $length = 8): string
    {
        $invoker = function () use ($isUnsigned): string {
            return BigIntegerGenerator::generateRandomIntegerByExponent(24, $isUnsigned)
                ->toString();
        };
        return $this->handler->returnUniqInt($invoker);
    }

    /**
     * 重複しない INT 型の乱数を返す
     * PHP_INT_MAX, PHP_INT_MIN で丸められることがあるため注意
     *
     * @param bool $isUnsigned
     * @param int $length
     * @return string
     */
    final public function int(bool $isUnsigned = true, int $length = 11): string
    {
        $invoker = function () use ($isUnsigned): string {
            return BigIntegerGenerator::generateRandomIntegerByExponent(32, $isUnsigned)
                ->toString();
        };
        return $this->handler->returnUniqInt($invoker);
    }

    /**
     * 重複しない BIGINT 型の乱数を返す
     * PHP_INT_MAX, PHP_INT_MIN で丸められることがあるため注意
     *
     * @param bool $isUnsigned
     * @param int $length
     * @return string
     */
    final public function bigInt(bool $isUnsigned = true, int $length = 20): string
    {
        $invoker = function () use ($isUnsigned): string {
            return BigIntegerGenerator::generateRandomIntegerByExponent(32, $isUnsigned)
                ->toString();
        };
        return $this->handler->returnUniqInt($invoker);
    }

    /**
     * 重複しない CHAR 型のランダムな文字列を返す
     *
     * @param int $length
     * @param string $keyspace
     * @return string
     */
    final public function char(
        int    $length = 16,
        string $keyspace = RandomStringGenerator::KEY_SPACE
    ): string
    {
        $invoker = function () use ($length, $keyspace): string {
            return RandomStringGenerator::char($length, $keyspace);
        };
        return $this->handler->returnUniqString($invoker);
    }

    /**
     * 重複しない VARCHAR 型のランダムな文字列を返す
     *
     * @param bool $isEmptyAllowed
     * @param int $length
     * @param string $keyspace
     * @return string
     */
    final public function varchar(
        bool   $isEmptyAllowed = true,
        int    $length = 16,
        string $keyspace = RandomStringGenerator::KEY_SPACE
    ): string
    {
        $invoker = function () use ($isEmptyAllowed, $length, $keyspace): string {
            return RandomStringGenerator::varchar($isEmptyAllowed, $length, $keyspace);
        };
        return $this->handler->returnUniqString($invoker);
    }

    /**
     * Mocker::varchar() のエイリアス
     *
     * @param bool $isEmptyAllowed
     * @param int $length
     * @param string $keyspace
     * @return string
     * @see Mocker::varchar()
     */
    final public function text(
        bool   $isEmptyAllowed = true,
        int    $length = 16,
        string $keyspace = RandomStringGenerator::KEY_SPACE
    ): string
    {
        return $this->varchar($isEmptyAllowed, $length, $keyspace);
    }

    /**
     * ランダムな DATETIME 型の文字列を返す
     *
     * @param int $range 現時点を基準とした秒数の幅
     *                      デフォルトは 157680000 ( 365 日 x 5 した秒数 )
     * @param string $format
     * @return string
     */
    final public function dateTime(
        int    $range = 157680000,
        string $format = \DateTimeInterface::RFC3339
    ): string
    {
        $sec = BigIntegerGenerator::generateRandomIntegerByRange("-{$range}", (string)$range);
        return (new \DateTimeImmutable())
            ->modify(sprintf('%s second', $sec))
            ->format($format);
    }

    /**
     * ランダムな BOOL 型の値を返す
     *
     * @return bool
     */
    final public function bool(): bool
    {
        return BigIntegerGenerator::generateRandomIntegerByRange('0', '1')
            ->equals(new BigInteger(0));
    }
}
<?php declare(strict_types=1);

namespace Test\UseCase\MySql80;

use Limo\MySql80\LiteralMocker;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    private LiteralMocker $m;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->m = new LiteralMocker(1000);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->m->setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->m->tearDown();
    }

    public function test(): void
    {
        $times = 200;
        $userIdList = [];
        for ($i = 0; $i < $times; ++$i) {
            $userIdList[] = $this->m->tinyInt();
        }
        self::assertCount($times, array_unique($userIdList));
    }
}

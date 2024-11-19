<?php

namespace Minhyung\TrifFxrt\Tests;

use Minhyung\TrifFxrt\TrifFxrt;
use PHPUnit\Framework\TestCase;

class TrifFxrtTest extends TestCase
{
    private ?TrifFxrt $trifFxrt = null;

    protected function setUp(): void
    {
        $serviceKey = $_ENV['SERVICE_KEY'];
        if (! $serviceKey) {
            $this->markTestSkipped('SERVICE_KEY is not set.');
        }

        $this->trifFxrt = new TrifFxrt($serviceKey);
    }

    public function testRetrieveTrifFxrtInfo(): void
    {
        $result = $this->trifFxrt->getRetrieveTrifFxrtInfo('202401118', 1);
        $this->assertIsArray($result);
    }
}

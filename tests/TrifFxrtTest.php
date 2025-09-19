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
        $result = $this->trifFxrt->getRetrieveTrifFxrtInfo('20240118', 1);
        $this->assertTrue($result->isSuccessful());
        $this->assertEquals('KRW', $result['KRW']->currSgn);
        $this->assertEquals($result['KRW']['currSgn'], $result['KRW']->currSgn);

        $result = $this->trifFxrt->getRetrieveTrifFxrtInfo('20240118', 3);
        $this->assertTrue($result->isFailed());
    }
}

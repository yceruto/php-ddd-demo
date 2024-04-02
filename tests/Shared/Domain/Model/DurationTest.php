<?php

namespace App\Tests\Shared\Domain\Model;

use App\Shared\Domain\Model\Duration;
use DateInterval;
use PHPUnit\Framework\TestCase;

class DurationTest extends TestCase
{
    public function testZeroDuration(): void
    {
        $duration1 = Duration::zero();
        $duration2 = Duration::from('P0Y0M0DT0H0M0S');

        self::assertSame('', $duration1->toDisplay());
        self::assertSame('', $duration2->toDisplay());
        self::assertTrue($duration1->isZero());
    }

    public function testToString(): void
    {
        $duration1 = Duration::from('P1Y2M3DT4H5M6S');
        $duration2 = Duration::from('P1Y2M3D');
        $duration3 = Duration::from('PT4H5M6S');

        self::assertSame('P1Y2M3DT4H5M6S', $duration1->toString());
        self::assertSame('P1Y2M3DT0H0M0S', $duration2->toString());
        self::assertSame('P0Y0M0DT4H5M6S', $duration3->toString());
    }

    public function testToDisplay(): void
    {
        $duration1 = Duration::from('P1Y2M3DT4H5M6S');
        $duration2 = Duration::from('PT4H5M6S');
        $duration3 = Duration::from('P1Y2M3D');
        $duration4 = Duration::from('P1YT4H');

        self::assertSame('1 year, 2 months, 3 days, 4 hours, 5 minutes, 6 seconds', $duration1->toDisplay());
        self::assertSame('4 hours, 5 minutes, 6 seconds', $duration2->toDisplay());
        self::assertSame('1 year, 2 months, 3 days', $duration3->toDisplay());
        self::assertSame('1 year, 4 hours', $duration4->toDisplay());
    }

    public function testAddDuration(): void
    {
        $duration1 = Duration::from('P1Y2M3DT4H5M6S');
        $duration2 = Duration::from('P1Y2M3DT4H5M6S');

        $duration = $duration1->add($duration2);

        self::assertSame('P2Y4M6DT8H10M12S', $duration->toString());
    }

    public function testSubtractDuration(): void
    {
        $duration1 = Duration::from('P1Y2M3DT4H5M6S');
        $duration2 = Duration::from('P1Y2M3DT4H5M6S');

        $duration = $duration1->subtract($duration2);

        self::assertTrue($duration->isZero());
    }

    public function testNegativeDuration(): void
    {
        $duration1 = Duration::from('P1Y');
        $duration2 = Duration::from('P2Y');

        $duration = $duration1->subtract($duration2);

        self::assertSame('-P1Y0M0DT0H0M0S', $duration->toString());
        self::assertSame('-1 year', $duration->toDisplay());
    }

    public function testValue(): void
    {
        $duration = Duration::from('P1Y2M3DT4H5M6S');

        self::assertEquals(new DateInterval('P1Y2M3DT4H5M6S'), $duration->value());
    }
}

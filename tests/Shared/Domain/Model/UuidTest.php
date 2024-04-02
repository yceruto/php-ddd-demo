<?php

namespace App\Tests\Shared\Domain\Model;

use App\Shared\Domain\Error\InvalidArgument;
use App\Shared\Domain\Model\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function testNew(): void
    {
        $uuid = Uuid::new();

        self::assertStringMatchesFormat('%x-%x-%x-%x-%x', $uuid->toString());
    }

    public function testFrom(): void
    {
        $uuid = Uuid::from('123e4567-e89b-12d3-a456-426614174000');

        self::assertSame('123e4567-e89b-12d3-a456-426614174000', $uuid->toString());
    }

    public function testEquals(): void
    {
        $uuid1 = Uuid::from('123e4567-e89b-12d3-a456-426614174000');
        $uuid2 = Uuid::from('123e4567-e89b-12d3-a456-426614174000');

        self::assertTrue($uuid1->equals($uuid2));
    }

    public function testFromEmptyValue(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The UUID value must not be empty.');

        Uuid::from('');
    }

    public function testFromInvalidValue(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The UUID value is not valid.');

        Uuid::from('invalid-uuid');
    }
}

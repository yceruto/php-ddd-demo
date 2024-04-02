<?php

namespace App\Tests\Shared\Domain\Model;

use App\Shared\Domain\Error\InvalidArgument;
use App\Shared\Domain\Model\NonEmptyString;
use PHPUnit\Framework\TestCase;

class NonEmptyStringTest extends TestCase
{
    public function testEmptyString(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The string value must not be empty.');

        NonEmptyString::from('');
    }
}

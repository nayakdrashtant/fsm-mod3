<?php

declare(strict_types=1);

namespace App\Tests;

use App\Automaton\Exceptions\InvalidSymbolException;
use App\ModThree\ModThree;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ModThreeTest extends TestCase
{
    #[DataProvider('validInputsProvider')]
    public function testRemainderForValidInputs(string $binary, int $expected): void
    {
        $svc = new ModThree();
        self::assertSame($expected, $svc->remainder($binary));
    }

    public static function validInputsProvider(): array
    {
        return [
            'empty treated as zero' => ['', 0],
            'zero' => ['0', 0],
            'one' => ['1', 1],
            'two' => ['10', 2],
            'three' => ['11', 0],
            'example 110' => ['110', 0],
            'example 1010' => ['1010', 1],
            'thirteen' => ['1101', 1],
            'fourteen' => ['1110', 2],
            'fifteen' => ['1111', 0],
            'leading zeros' => ['0001111', 0],
            'large input still ok' => [str_repeat('1', 128), (int)(bindec(str_repeat('1', 16)) % 3)], // sanity check pattern
        ];
    }

    public function testInvalidCharacterThrows(): void
    {
        $svc = new ModThree();

        $this->expectException(InvalidSymbolException::class);
        $svc->remainder('10a01');
    }
}
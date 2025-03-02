<?php
declare(strict_types=1);

namespace Czarpino\PhpCrockford32\Tests;

use Czarpino\PhpCrockford32\CrockfordBase32;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EncodeTest extends TestCase
{
    public static function provideSymbols(): array
    {
        return [
            '0' => [0, '0'],
            '1' => [1, '1'],
            '2' => [2, '2'],
            '3' => [3, '3'],
            '4' => [4, '4'],
            '5' => [5, '5'],
            '6' => [6, '6'],
            '7' => [7, '7'],
            '8' => [8, '8'],
            '9' => [9, '9'],
            'A' => [10, 'A'],
            'B' => [11, 'B'],
            'C' => [12, 'C'],
            'D' => [13, 'D'],
            'E' => [14, 'E'],
            'F' => [15, 'F'],
            'G' => [16, 'G'],
            'H' => [17, 'H'],
            'J' => [18, 'J'],
            'K' => [19, 'K'],
            'M' => [20, 'M'],
            'N' => [21, 'N'],
            'P' => [22, 'P'],
            'Q' => [23, 'Q'],
            'R' => [24, 'R'],
            'S' => [25, 'S'],
            'T' => [26, 'T'],
            'V' => [27, 'V'],
            'W' => [28, 'W'],
            'X' => [29, 'X'],
            'Y' => [30, 'Y'],
            'Z' => [31, 'Z'],
        ];
    }

    public static function provide6To10BitNumbers(): array
    {
        return [
            [0b1_00000, '10'],
            [0b10_00000, '20'],
            [0b100_00000, '40'],
            [0b1000_00000, '80'],
            [0b10000_00000, 'G0'],
        ];
    }

    public static function provide11To15BitNumbers(): array
    {
        return [
            [0b1_00000_00000, '100'],
            [0b10_00000_00000, '200'],
            [0b100_00000_00000, '400'],
            [0b1000_00000_00000, '800'],
            [0b10000_00000_00000, 'G00'],
        ];
    }

    #[DataProvider('provideSymbols')]
    public function testCanEncode5BitsWithUniqueSymbols(int $value, string $encodeSymbol): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($encodeSymbol, $crockfordBase32->encode($value));
    }

    #[DataProvider('provide6To10BitNumbers')]
    public function testCanEncode6To10BitNumbers(int $_6To10BitNumber, string $expectedEncodedValue): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($expectedEncodedValue, $crockfordBase32->encode($_6To10BitNumber));
    }

    #[DataProvider('provide11To15BitNumbers')]
    public function testCanEncode11To15BitNumber(int $_11To15BitNumber, string $expectedEncodedValue): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($expectedEncodedValue, $crockfordBase32->encode($_11To15BitNumber));
    }
}

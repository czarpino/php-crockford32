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
            '0 is encoded as 0' => [0, '0'],
            '1 is encoded as 1' => [1, '1'],
            '2 is encoded as 2' => [2, '2'],
            '3 is encoded as 3' => [3, '3'],
            '4 is encoded as 4' => [4, '4'],
            '5 is encoded as 5' => [5, '5'],
            '6 is encoded as 6' => [6, '6'],
            '7 is encoded as 7' => [7, '7'],
            '8 is encoded as 8' => [8, '8'],
            '9 is encoded as 9' => [9, '9'],
            '10 is encoded as A' => [10, 'A'],
            '11 is encoded as B' => [11, 'B'],
            '12 is encoded as C' => [12, 'C'],
            '13 is encoded as D' => [13, 'D'],
            '14 is encoded as E' => [14, 'E'],
            '15 is encoded as F' => [15, 'F'],
            '16 is encoded as G' => [16, 'G'],
            '17 is encoded as H' => [17, 'H'],
            '18 is encoded as J' => [18, 'J'],
            '19 is encoded as K' => [19, 'K'],
            '20 is encoded as M' => [20, 'M'],
            '21 is encoded as N' => [21, 'N'],
            '22 is encoded as P' => [22, 'P'],
            '23 is encoded as Q' => [23, 'Q'],
            '24 is encoded as R' => [24, 'R'],
            '25 is encoded as S' => [25, 'S'],
            '26 is encoded as T' => [26, 'T'],
            '27 is encoded as V' => [27, 'V'],
            '28 is encoded as W' => [28, 'W'],
            '29 is encoded as X' => [29, 'X'],
            '30 is encoded as Y' => [30, 'Y'],
            '31 is encoded as Z' => [31, 'Z'],
        ];
    }

    public static function provide6To10BitNumbers(): array
    {
        return [
            '0b1_00000 is encoded to 10' => [0b1_00000, '10'],
            '0b10_00000 is encoded to 20' => [0b10_00000, '20'],
            '0b100_00000 is encoded to 40' => [0b100_00000, '40'],
            '0b1000_00000 is encoded to 80' => [0b1000_00000, '80'],
            '0b10000_00000 is encoded to G0' => [0b10000_00000, 'G0'],
        ];
    }

    public static function provide11To15BitNumbers(): array
    {
        return [
            '0b1_00000_00000 is encoded to 100' => [0b1_00000_00000, '100'],
            '0b10_00000_00000 is encoded to 200' => [0b10_00000_00000, '200'],
            '0b100_00000_00000 is encoded to 400' => [0b100_00000_00000, '400'],
            '0b1000_00000_00000 is encoded to 800' => [0b1000_00000_00000, '800'],
            '0b10000_00000_00000 is encoded to G00' => [0b10000_00000_00000, 'G00'],
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

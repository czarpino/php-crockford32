<?php
declare(strict_types=1);

namespace Czarpino\PhpCrockford32\Tests;

use Czarpino\PhpCrockford32\Base32ConversionException;
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

    public static function provide10To30BitNumberEncodings(): array
    {
        return [
            '10-bit: 0b11111_11111 is encoded to ZZ' => ['ZZ', 0b11111_11111],
            '15-bit: 0b11111_11111_11111 is encoded to ZZZ' => ['ZZZ', 0b11111_11111_11111],
            '20-bit: 0b11111_11111_11111_11111 is encoded to ZZZZ' => ['ZZZZ', 0b11111_11111_11111_11111],
            '25-bit: 0b11111_11111_11111_11111_11111 is encoded to ZZZZZ' => ['ZZZZZ', 0b11111_11111_11111_11111_11111],
            '30-bit: 0b11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZ' => ['ZZZZZZ', 0b11111_11111_11111_11111_11111_11111],
        ];
    }

    public static function provide35To60BitNumberEncodings(): array
    {
        return [
            '35-bit: 0b11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZ' => ['ZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111],
            '40-bit: 0b11111_11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZZ' => ['ZZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111_11111],
            '45-bit: 0b11111_11111_11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZZZ' => ['ZZZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111_11111_11111],
            '50-bit: 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZZZZ' => ['ZZZZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111],

            // Full range of 55-bit and over do not work on 64-bit PHP
            //'55-bit: 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZZZZZ' => ['ZZZZZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111],
            //'60-bit: 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZZZZZZ' => ['ZZZZZZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111],
        ];
    }

    public function testThrowsExceptionWhenEncodingNegativeNumber(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->expectException(Base32ConversionException::class);
        $this->expectExceptionMessage('Cannot encode negative numbers');
        $crockfordBase32->encode(-1);
    }

    #[DataProvider('provideSymbols')]
    public function testCanEncode5BitsWithUniqueSymbols(int $value, string $encodeSymbol): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($encodeSymbol, $crockfordBase32->encode($value));
    }

    #[DataProvider('provide10To30BitNumberEncodings')]
    public function testCanEncode10To30BitNumbers(string $encoded, int $number): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($encoded, $crockfordBase32->encode($number));
    }

    #[DataProvider('provide35To60BitNumberEncodings')]
    public function testCanEncode35To60BitNumbers(string $encoded, int $number): void
    {
        if (4 === PHP_INT_SIZE) {
            self::markTestSkipped('Requires 64-bit PHP');
        }

        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($encoded, $crockfordBase32->encode($number));
    }
}

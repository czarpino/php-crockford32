<?php
declare(strict_types=1);

namespace Czarpino\PhpCrockford32\Tests;

use Czarpino\PhpCrockford32\Base32ConversionException;
use Czarpino\PhpCrockford32\CrockfordBase32;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class EncodeTest extends TestCase
{
    public static function provide5BitNumberEncodings(): array
    {
        return [
            '5-bit: 0b00000 is encoded to 0' => ['0', 0b00000],
            '5-bit: 0b00001 is encoded to 1' => ['1', 0b00001],
            '5-bit: 0b00010 is encoded to 2' => ['2', 0b00010],
            '5-bit: 0b00011 is encoded to 3' => ['3', 0b00011],
            '5-bit: 0b00100 is encoded to 4' => ['4', 0b00100],
            '5-bit: 0b00101 is encoded to 5' => ['5', 0b00101],
            '5-bit: 0b00110 is encoded to 6' => ['6', 0b00110],
            '5-bit: 0b00111 is encoded to 7' => ['7', 0b00111],
            '5-bit: 0b01000 is encoded to 8' => ['8', 0b01000],
            '5-bit: 0b01001 is encoded to 9' => ['9', 0b01001],
            '5-bit: 0b01010 is encoded to A' => ['A', 0b01010],
            '5-bit: 0b01011 is encoded to B' => ['B', 0b01011],
            '5-bit: 0b01100 is encoded to C' => ['C', 0b01100],
            '5-bit: 0b01101 is encoded to D' => ['D', 0b01101],
            '5-bit: 0b01110 is encoded to E' => ['E', 0b01110],
            '5-bit: 0b01111 is encoded to F' => ['F', 0b01111],
            '5-bit: 0b10000 is encoded to G' => ['G', 0b10000],
            '5-bit: 0b10001 is encoded to H' => ['H', 0b10001],
            '5-bit: 0b10010 is encoded to J' => ['J', 0b10010],
            '5-bit: 0b10011 is encoded to K' => ['K', 0b10011],
            '5-bit: 0b10100 is encoded to M' => ['M', 0b10100],
            '5-bit: 0b10101 is encoded to N' => ['N', 0b10101],
            '5-bit: 0b10110 is encoded to P' => ['P', 0b10110],
            '5-bit: 0b10111 is encoded to Q' => ['Q', 0b10111],
            '5-bit: 0b11000 is encoded to R' => ['R', 0b11000],
            '5-bit: 0b11001 is encoded to S' => ['S', 0b11001],
            '5-bit: 0b11010 is encoded to T' => ['T', 0b11010],
            '5-bit: 0b11011 is encoded to V' => ['V', 0b11011],
            '5-bit: 0b11100 is encoded to W' => ['W', 0b11100],
            '5-bit: 0b11101 is encoded to X' => ['X', 0b11101],
            '5-bit: 0b11110 is encoded to Y' => ['Y', 0b11110],
            '5-bit: 0b11111 is encoded to Z' => ['Z', 0b11111],
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
            '55-bit: 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZZZZZ' => ['ZZZZZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111],
            '60-bit: 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111 is encoded to ZZZZZZZZZZZZ' => ['ZZZZZZZZZZZZ', 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111],
        ];
    }

    public function testThrowsExceptionWhenEncodingNegativeNumber(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->expectException(Base32ConversionException::class);
        $this->expectExceptionMessage('Cannot encode negative numbers');
        $crockfordBase32->encode(-1);
    }

    #[DataProvider('provide5BitNumberEncodings')]
    #[DataProvider('provide10To30BitNumberEncodings')]
    #[DataProvider('provide35To60BitNumberEncodings')]
    public function testCanEncode(string $encoded, int $number): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($encoded, $crockfordBase32->encode($number));
    }
}

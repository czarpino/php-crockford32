<?php
declare(strict_types=1);

use Czarpino\PhpCrockford32\Base32ConversionException;
use Czarpino\PhpCrockford32\CrockfordBase32;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ChecksumTest extends TestCase
{
    public static function provideCheckSymbolExpectations(): array
    {
        return [
            // Base
            '0 has check symbol 0' => ['0', 0],
            '1 has check symbol 1' => ['1', 1],
            '2 has check symbol 2' => ['2', 2],
            '3 has check symbol 3' => ['3', 3],
            '4 has check symbol 4' => ['4', 4],
            '5 has check symbol 5' => ['5', 5],
            '6 has check symbol 6' => ['6', 6],
            '7 has check symbol 7' => ['7', 7],
            '8 has check symbol 8' => ['8', 8],
            '9 has check symbol 9' => ['9', 9],
            '10 has check symbol A' => ['A', 10],
            '11 has check symbol B' => ['B', 11],
            '12 has check symbol C' => ['C', 12],
            '13 has check symbol D' => ['D', 13],
            '14 has check symbol E' => ['E', 14],
            '15 has check symbol F' => ['F', 15],
            '16 has check symbol G' => ['G', 16],
            '17 has check symbol H' => ['H', 17],
            '18 has check symbol J' => ['J', 18],
            '19 has check symbol K' => ['K', 19],
            '20 has check symbol M' => ['M', 20],
            '21 has check symbol N' => ['N', 21],
            '22 has check symbol P' => ['P', 22],
            '23 has check symbol Q' => ['Q', 23],
            '24 has check symbol R' => ['R', 24],
            '25 has check symbol S' => ['S', 25],
            '26 has check symbol T' => ['T', 26],
            '27 has check symbol V' => ['V', 27],
            '28 has check symbol W' => ['W', 28],
            '29 has check symbol X' => ['X', 29],
            '30 has check symbol Y' => ['Y', 30],
            '31 has check symbol Z' => ['Z', 31],
            '32 has check symbol *' => ['*', 32],
            '33 has check symbol ~' => ['~', 33],
            '34 has check symbol $' => ['$', 34],
            '35 has check symbol =' => ['=', 35],
            '36 has check symbol U' => ['U', 36],

            // Modulo checks
            '37 has check symbol 0' => ['0', 37],
            '38 has check symbol 1' => ['1', 38],
            '74 has check symbol 0' => ['0', 74],

            // Large numbers
            '123456 has check symbol R' => ['R', 123456],
            '456789 has check symbol R' => ['R', 456789],
            '789012 has check symbol R' => ['R', 789012],
            '12345 has check symbol R' => ['R', 12345],
            '345678 has check symbol R' => ['R', 345678],

            // Very large numbers
            '1234567890 has check symbol V' => ['V', 1234567890],
            '2147483647 (PHP_INT_MAX on 32-bit) has check symbol N' => ['N', 2147483647],

            // Ultra large numbers
            '1234567890987654321 has check symbol W' => ['W', 1234567890987654321],
            '9223372036854775807 (PHP_INT_MAX on 64-bit) has check symbol 5' => ['5', 9223372036854775807],
        ];
    }

    #[DataProvider('provideCheckSymbolExpectations')]
    public function testGenerates37UniqueCheckSymbols(string $expectedCheckSymbol, int $number): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $checksum = $crockfordBase32->checksum($number);
        self::assertSame($expectedCheckSymbol, $checksum);
    }

    public function testThrowsExceptionWhenNumberIsNegative(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->expectException(Base32ConversionException::class);
        $this->expectExceptionMessage('Checksum for negative integer is not supported');
        $crockfordBase32->checksum(-1);
    }
}

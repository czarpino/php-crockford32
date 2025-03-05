<?php

declare(strict_types=1);

use Czarpino\PhpCrockford32\Base32ConversionException;
use Czarpino\PhpCrockford32\CrockfordBase32;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DecodeTest extends TestCase
{
    public static function provideInvalidBase32Numbers(): array
    {
        return [
            'empty string' => [''],
            'invalid single digit (!)' => ['!'],
            'double digit with `!`' => ['!0'],
            'unsupported character `u`' => ['u'],
        ];
    }

    public static function provide5BitNumberDecodings(): array
    {
        return [
            '0 is decoded as 0' => [0, '0'],
            '1 is decoded as 1' => [1, '1'],
            '2 is decoded as 2' => [2, '2'],
            '3 is decoded as 3' => [3, '3'],
            '4 is decoded as 4' => [4, '4'],
            '5 is decoded as 5' => [5, '5'],
            '6 is decoded as 6' => [6, '6'],
            '7 is decoded as 7' => [7, '7'],
            '8 is decoded as 8' => [8, '8'],
            '9 is decoded as 9' => [9, '9'],
            'A is decoded as 10' => [10, 'A'],
            'B is decoded as 11' => [11, 'B'],
            'C is decoded as 12' => [12, 'C'],
            'D is decoded as 13' => [13, 'D'],
            'E is decoded as 14' => [14, 'E'],
            'F is decoded as 15' => [15, 'F'],
            'G is decoded as 16' => [16, 'G'],
            'H is decoded as 17' => [17, 'H'],
            'J is decoded as 18' => [18, 'J'],
            'K is decoded as 19' => [19, 'K'],
            'M is decoded as 20' => [20, 'M'],
            'N is decoded as 21' => [21, 'N'],
            'P is decoded as 22' => [22, 'P'],
            'Q is decoded as 23' => [23, 'Q'],
            'R is decoded as 24' => [24, 'R'],
            'S is decoded as 25' => [25, 'S'],
            'T is decoded as 26' => [26, 'T'],
            'V is decoded as 27' => [27, 'V'],
            'W is decoded as 28' => [28, 'W'],
            'X is decoded as 29' => [29, 'X'],
            'Y is decoded as 30' => [30, 'Y'],
            'Z is decoded as 31' => [31, 'Z'],
        ];
    }

    public static function provide10To30BitNumberDecodings(): array
    {
        return [
            '10-bit: ZZ is decoded to 0b11111_11111' => [0b11111_11111, 'ZZ'],
            '15-bit: ZZ-Z is decoded to 0b11111_11111_11111' => [0b11111_11111_11111, 'ZZZ'],
            '20-bit: ZZ-ZZ is decoded to 0b11111_11111_11111_11111' => [0b11111_11111_11111_11111, 'ZZZZ'],
            '25-bit: ZZ-ZZ-Z is decoded to 0b11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111, 'ZZZZZ'],
            '30-bit: ZZ-ZZ-ZZ is decoded to 0b11111_11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111_11111, 'ZZZZZZ'],
        ];
    }

    public static function provide35To60BitNumberDecodings(): array
    {
        return [
            '35-bit: ZZ-ZZ-ZZ-Z is decoded to 0b11111_11111_11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111_11111_11111, 'ZZZZZZZ'],
            '40-bit: ZZ-ZZ-ZZ-ZZ is decoded to 0b11111_11111_11111_11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111_11111_11111_11111, 'ZZZZZZZZ'],
            '45-bit: ZZ-ZZ-ZZ-ZZ-Z is decoded to 0b11111_11111_11111_11111_11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111_11111_11111_11111_11111, 'ZZZZZZZZZ'],
            '50-bit: ZZ-ZZ-ZZ-ZZ-ZZ is decoded to 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111, 'ZZZZZZZZZZ'],
            '55-bit: ZZ-ZZ-ZZ-ZZ-ZZ-Z is decoded to 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111, 'ZZZZZZZZZZZ'],
            '60-bit: ZZ-ZZ-ZZ-ZZ-ZZ-ZZ is decoded to 0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111' => [0b11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111_11111, 'ZZZZZZZZZZZZ'],
        ];
    }

    #[DataProvider('provideInvalidBase32Numbers')]
    public function testThrowsExceptionWhenInputContainsInvalidCharacters(string $invalidBase32Number): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->expectException(Base32ConversionException::class);
        $this->expectExceptionMessage('Invalid base32 number');
        $crockfordBase32->decode($invalidBase32Number);
    }

    #[DataProvider('provide5BitNumberDecodings')]
    #[DataProvider('provide10To30BitNumberDecodings')]
    #[DataProvider('provide35To60BitNumberDecodings')]
    public function testCanDecode(int $decoded, string $encoded): void
    {
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals($decoded, $crockfordBase32->decode($encoded));
    }
}

<?php

declare(strict_types=1);

namespace Czarpino\PhpCrockford32;

/**
 * PHP implementation of CrockfordBase32 encoding
 *
 * @author Czar Pino <inbox@czarpino.com>
 */
class CrockfordBase32
{
    private const ENCODING_SYMBOLS_LOOKUP = [
        '0',
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'J',
        'K',
        'M',
        'N',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'V',
        'W',
        'X',
        'Y',
        'Z',
        '*',
        '~',
        '$',
        '=',
        'U',
    ];

    private const DECODING_SYMBOLS_LOOKUP = [
        '0' => 0b00000,
        '1' => 0b00001,
        '2' => 0b00010,
        '3' => 0b00011,
        '4' => 0b00100,
        '5' => 0b00101,
        '6' => 0b00110,
        '7' => 0b00111,
        '8' => 0b01000,
        '9' => 0b01001,
        'A' => 0b01010,
        'B' => 0b01011,
        'C' => 0b01100,
        'D' => 0b01101,
        'E' => 0b01110,
        'F' => 0b01111,
        'G' => 0b10000,
        'H' => 0b10001,
        'J' => 0b10010,
        'K' => 0b10011,
        'M' => 0b10100,
        'N' => 0b10101,
        'P' => 0b10110,
        'Q' => 0b10111,
        'R' => 0b11000,
        'S' => 0b11001,
        'T' => 0b11010,
        'V' => 0b11011,
        'W' => 0b11100,
        'X' => 0b11101,
        'Y' => 0b11110,
        'Z' => 0b11111,
    ];

    /**
     * Encode a number to Crockford Base32
     *
     * @param int $number
     * @return string
     */
    public function encode(int $number): string
    {
        if ($number < 32) {
            return self::ENCODING_SYMBOLS_LOOKUP[$number];
        }

        $encoded = '';
        do {
            $encoded = self::ENCODING_SYMBOLS_LOOKUP[$number % 32] . $encoded;
            $number = (int) ($number / 32);
        } while($number > 0);

        return $encoded;
    }

    /**
     * Decode a Crockford Base32 encoded number
     *
     * @param string $encoded
     * @return int
     * @throws Base32ConversionException
     */
    public function decode(string $encoded): int
    {
        // strip separators
        $cleaned = str_replace('-', '', $encoded);
        if ('' === $cleaned) {
            throw new Base32ConversionException('Invalid base32 number');
        }

        // normalize encoded string
        $normalized = str_replace(
            ['I', 'L', 'O'],
            ['1', '1', '0'],
            strtoupper($cleaned)
        );

        $decoded = 0;
        foreach (str_split($normalized) as $digit) {
            $value = self::DECODING_SYMBOLS_LOOKUP[$digit] ?? null;
            if (null === $value) {
                throw new Base32ConversionException('Invalid base32 number');
            }

            $decoded = $decoded * 32 + $value;
        }

        return $decoded;
    }

    // TODO: implement and remove encodeWithCheckSymbol
    public function checksum(int $number): string
    {
        return '';
    }
}

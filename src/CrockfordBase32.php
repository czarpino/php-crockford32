<?php

declare(strict_types=1);

namespace Czarpino\PhpCrockford32;

class CrockfordBase32
{
    private const SYMBOLS = [
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
    ];

    public function encode(int $number): string
    {
        if ($number >= count(self::SYMBOLS)) {
            $lastDigit = $number % count(self::SYMBOLS);
            $encoded = $this->encode((int)($number / count(self::SYMBOLS)));
            return $encoded . self::SYMBOLS[$lastDigit];
        }
        return self::SYMBOLS[$number];
    }
}

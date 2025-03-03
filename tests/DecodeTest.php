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

    public function testCanDecodeSingleDigits(): void
    {
        // TODO use binary representation for ease of inspection
        $crockfordBase32 = new CrockfordBase32();
        $this->assertEquals(0, $crockfordBase32->decode('0'));
        $this->assertEquals(1, $crockfordBase32->decode('1'));
        $this->assertEquals(2, $crockfordBase32->decode('2'));
        $this->assertEquals(3, $crockfordBase32->decode('3'));
        $this->assertEquals(4, $crockfordBase32->decode('4'));
        $this->assertEquals(5, $crockfordBase32->decode('5'));
        $this->assertEquals(6, $crockfordBase32->decode('6'));
        $this->assertEquals(7, $crockfordBase32->decode('7'));
        $this->assertEquals(8, $crockfordBase32->decode('8'));
        $this->assertEquals(9, $crockfordBase32->decode('9'));
        $this->assertEquals(10, $crockfordBase32->decode('A'));
        $this->assertEquals(11, $crockfordBase32->decode('B'));
        $this->assertEquals(12, $crockfordBase32->decode('C'));
        $this->assertEquals(13, $crockfordBase32->decode('D'));
        $this->assertEquals(14, $crockfordBase32->decode('E'));
        $this->assertEquals(15, $crockfordBase32->decode('F'));
        $this->assertEquals(16, $crockfordBase32->decode('G'));
        $this->assertEquals(17, $crockfordBase32->decode('H'));
        $this->assertEquals(18, $crockfordBase32->decode('J'));
        $this->assertEquals(19, $crockfordBase32->decode('K'));
        $this->assertEquals(20, $crockfordBase32->decode('M'));
        $this->assertEquals(21, $crockfordBase32->decode('N'));
        $this->assertEquals(22, $crockfordBase32->decode('P'));
        $this->assertEquals(23, $crockfordBase32->decode('Q'));
        $this->assertEquals(24, $crockfordBase32->decode('R'));
        $this->assertEquals(25, $crockfordBase32->decode('S'));
        $this->assertEquals(26, $crockfordBase32->decode('T'));
        $this->assertEquals(27, $crockfordBase32->decode('V'));
        $this->assertEquals(28, $crockfordBase32->decode('W'));
        $this->assertEquals(29, $crockfordBase32->decode('X'));
        $this->assertEquals(30, $crockfordBase32->decode('Y'));
        $this->assertEquals(31, $crockfordBase32->decode('Z'));
    }

    public function testCanDecodeDoubleDigits(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(0b00001_00000, $crockfordBase32->decode('10'));
        self::assertEquals(0b00010_00000, $crockfordBase32->decode('20'));
        self::assertEquals(0b00011_00000, $crockfordBase32->decode('30'));
        self::assertEquals(0b00011_00001, $crockfordBase32->decode('31'));
        self::assertEquals(0b00011_00010, $crockfordBase32->decode('32'));
        self::assertEquals(0b00011_00011, $crockfordBase32->decode('33'));
    }

    public function testCanDecodeTripleDigits(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(0b00001_00000_00000, $crockfordBase32->decode('100'));
        self::assertEquals(0b00010_00000_00000, $crockfordBase32->decode('200'));
        self::assertEquals(0b00011_00000_00000, $crockfordBase32->decode('300'));
        self::assertEquals(0b00011_00000_00001, $crockfordBase32->decode('301'));
        self::assertEquals(0b00011_00000_00010, $crockfordBase32->decode('302'));
        self::assertEquals(0b00011_00000_00011, $crockfordBase32->decode('303'));
    }

    public function testCanDecodeMultipleDigits(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(
            0b10000_10000_10000_10000_10000_10000_10000_10000_10000_10000,
            $crockfordBase32->decode('GGGGGGGGGG')
        );
        self::assertEquals(
            0b00000_00001_10010_10101_01011_01010_10010_00000_11110_01010,
            $crockfordBase32->decode('01JNBAJ0YA')
        );
    }

    public function testIgnoresHyphens(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(
            0b00000_00001_10010_10101_01011_01010_10010_00000_11110_01010,
            $crockfordBase32->decode('01-JN-BA-J0-YA')
        );
    }

    public function testIgnoresCapitalization(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(
            0b00000_00001_10010_10101_01011_01010_10010_00000_11110_01010,
            $crockfordBase32->decode('01-jn-ba-j0-ya')
        );
    }

    public function testIgnoresConvertsLetterIToNumber1(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(
            0b00001_00001_00001,
            $crockfordBase32->decode('III')
        );
        self::assertEquals(
            0b00001_00001_00001,
            $crockfordBase32->decode('iii')
        );
    }

    public function testIgnoresConvertsLetterLToNumber1(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(
            0b00001_00001_00001,
            $crockfordBase32->decode('LLL')
        );
        self::assertEquals(
            0b00001_00001_00001,
            $crockfordBase32->decode('lll')
        );
    }

    public function testIgnoresConvertsLetterOToNumber0(): void
    {
        $crockfordBase32 = new CrockfordBase32();
        self::assertEquals(
            0b00001_00000_00000,
            $crockfordBase32->decode('1OO')
        );
        self::assertEquals(
            0b00001_00000_00000,
            $crockfordBase32->decode('1oo')
        );
    }
}

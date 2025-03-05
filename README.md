# Crockford Base32 encoding for PHP

A simple and faithful implementation of Douglas Crockford's Base32 encoding in PHP as specified in https://www.crockford.com/base32.html. Supports encoding and decoding of up to 60-bit integers.

## Usage
Encode and decode integers from 0 up to `1152921504606846975`(largest 60-bit). Since Crockford32 processes 5 bits at a time, the full 60-65-bit range is not fully supported in a 64-bit system. The same applies to 30-35-bit range on a 32-bit system.

```php
<?php
declare(strict_types=1);

use Czarpino\PhpCrockford32\CrockfordBase32();

$crockfordBase32 = new CrockfordBase32();
$encoded = $crockfordBase32->encode(1152921504606846975); // ZZZZZZZZZZZZ
$decoded = $crockfordBase32->decode('ZZZZZZZZZZZZ');      // 1152921504606846975
```

### Encoding with Check Symbol

```php
declare(strict_types=1);

use Czarpino\PhpCrockford32\CrockfordBase32();

$crockfordBase32 = new CrockfordBase32();
$encoded = $crockfordBase32->encode(1152921504606846975); // ZZZZZZZZZZZZ
$checksum = $crockfordBase32->checksum($number);          // 9
$encodedWithCheckSum = $encoded . $checksum;
```

### Decoding with Check Symbol

```php
declare(strict_types=1);

use Czarpino\PhpCrockford32\CrockfordBase32();

$encodedWithCheckSum = 'ZZZZZZZZZZZZ9';
$encoded = substr($encodedWithCheckSum, 0, -1); // ZZZZZZZZZZZZ
$checksum = substr($encodedWithCheckSum, -1);   // 9
$decoded = $crockfordBase32->decode($encoded);  // 11529215046068469751152921504606846975
if ($checksum !== $crockfordBase32->checksum($decoded)) {
    // early return or throw exception
}
```
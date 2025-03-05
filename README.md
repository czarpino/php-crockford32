# Crockford Base32 encoding for PHP

A simple and faithful implementation of Douglas Crockford's Base32 encoding in PHP as specified in https://www.crockford.com/base32.html. Supports encoding and decoding of up to 60-bit integers.

## Usage
Encode and decode integers from 0 up to `1152921504606846975`(largest 60-bit). Since Crockford32 processes 5 bits at a time, the full 60-65-bit range is not fully supported in a 64-bit system. The same applies to 30-35-bit range on a 32-bit system.

```php
use Czarpino\PhpCrockford32\CrockfordBase32;

$crockfordBase32 = new CrockfordBase32();
$encoded = $crockfordBase32->encode(1152921504606846975); // ZZZZZZZZZZZZ
$decoded = $crockfordBase32->decode('ZZZZZZZZZZZZ');      // 1152921504606846975
```

### Encoding with Check Symbol

```php
use Czarpino\PhpCrockford32\CrockfordBase32;

$crockfordBase32 = new CrockfordBase32();
$encoded = $crockfordBase32->encode(1152921504606846975);
$checksum = $crockfordBase32->checksum($number);
$encodedWithCheckSum = $encoded . $checksum;
```

### Decoding with Check Symbol

```php
use Czarpino\PhpCrockford32\CrockfordBase32;

$encodedWithCheckSum = 'ZZZZZZZZZZZZ9';
$encoded = substr($encodedWithCheckSum, 0, -1);
$checksum = substr($encodedWithCheckSum, -1);

$crockfordBase32 = new CrockfordBase32();
$decoded = $crockfordBase32->decode($encoded);
$isValid = $checksum === $crockfordBase32->checksum($decoded);
```
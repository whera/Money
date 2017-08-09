# Money Value Object
Value object for handling monetary values

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/whera/Money/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/whera/Money/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/whera/Money/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/whera/Money/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/whera/Money/badges/build.png?b=master)](https://scrutinizer-ci.com/g/whera/Money/build-status/master)
[![Packagist](https://img.shields.io/packagist/v/wsw/money.svg?style=flat-square)](https://github.com/whera/Money)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg?style=flat-square)](https://github.com/whera/Money/blob/master/LICENSE)

## Installation
Via Composer:

```bash
composer require wsw/money
```

## Usage

Instantiating a value:

``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;

$money = new Money('1500.9999', new Currency('USD'));
```
Output values:
``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;

$money = new Money("1500.9999", new Currency("USD"));

echo $money->getAmount();   // (string)  1500.999900
echo $money->getMicros();   // (integer) 1500999900
echo $money->getTruncate(); // (string)  1500.99
echo $money->getRound();    // (string)  1501.00
echo $money->getFormat();   // (string)  1.501,00

echo $money; // (string) 1.501,00
```

We verify that the values are equal:
``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;

$money = new Money("1500.00", new Currency("USD"));
$money2 = new Money("1500.00", new Currency("USD"));
$money3 = new Money("1000.00", new Currency("USD"));

var_dump($money->equals($money2)); // bool(true)
var_dump($money->equals($money3)); // bool(false)
```

Compare values:
``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;

$money  = new Money("1500.00", new Currency("USD"));
$money2 = new Money("1500.00", new Currency("USD"));
$money3 = new Money("1000.00", new Currency("USD"));

// Returns zero (0) when values and currencies are equal.
var_dump($money->compare($money2)); // int(0)

// Returns one (1) when the left object has the value greater than the right object.
var_dump($money->compare($money3)); // int(1)

// Returns minus one (-1) when the right object has the value greater than the left object.
var_dump($money3->compare($money)); // int(-1)
```

Add value:
``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;

$money = new Money('100', new Currency('USD'));
$addValue = new Money('50', new Currency('USD'));

$newMoney = $money->add($addValue);

echo $newMoney->getAmount(); // (string) 150.000000
echo $newMoney->getTruncate(); // (string) 150.00
echo $newMoney->getRound(); // (string) 150.00
echo $newMoney->getFormat(); // (string) 150,00

echo $newMoney; // (string) 150,00
```

Add percentage value:
``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;
use WSW\Money\Percentage;

$money = new Money('100', new Currency('USD'));
$percent = new Percentage("75%");

$newMoney = $money->addPercent($percent);

echo $newMoney->getAmount(); // (string) 175.000000
echo $newMoney->getTruncate(); // (string) 175.00
echo $newMoney->getRound(); // (string) 175.00
echo $newMoney->getFormat(); // (string) 175,00

echo $newMoney; // (string) 175,00
```

Subtract value:
``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;

$money = new Money('100', new Currency('USD'));
$subValue = new Money('60.75', new Currency('USD'));

$newMoney = $money->sub($subValue);

echo $newMoney->getAmount(); // (string) 39.250000
echo $newMoney->getTruncate(); // (string) 39.25
echo $newMoney->getRound(); // (string) 39.25
echo $newMoney->getFormat(); // (string) 39,25

echo $newMoney; // (string) 39,25
```

Subtract percentage value:
``` php
<?php

use WSW\Money\Currency;
use WSW\Money\Money;
use WSW\Money\Percentage;

$money = new Money('100', new Currency('USD'));
$percent = new Percentage("75%");

$newMoney = $money->subPercent($percent);

echo $newMoney->getAmount(); // (string) 25.000000
echo $newMoney->getTruncate(); // (string) 25.00
echo $newMoney->getRound(); // (string) 25.00
echo $newMoney->getFormat(); // (string) 25,00

echo $newMoney; // (string) 25,00
```

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email **ronaldo@whera.com.br** instead of using the issue tracker.

## Credits

- [Ronaldo Matos Rodrigues](https://github.com/whera)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
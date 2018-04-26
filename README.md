# geta-setta

![Build status](https://img.shields.io/circleci/project/github/pinekta/geta-setta.svg)
[![Coverage Status](https://coveralls.io/repos/github/pinekta/geta-setta/badge.svg?branch=master)](https://coveralls.io/github/pinekta/geta-setta?branch=master)

<!--
badge
logo image
-->

This library 'geta-setta' provides getter method and setter method.

Using the magic method `__call` when be invoked inaccessible method,
if the prefix of the method name is `set`, an argument value is set to the property.
And if the prefix of the method name is `get`, a value of the property is returned.

When those prefix is nothing,
if there is the argument, an argument value is set to the property with the same name as the method name.
And if there is not the argument, a value of the property with the same name as the method name is returned.

geta-setta requires PHP >= 5.4.0.

<!--
## Installation

```
$ composer require pinekta/geta-setta
```
-->

## Usage

```php
<?php

namespace Foo\bar;

use Pinekta\GetaSetta\AccessorAvailable;

class AudioPlayer
{
    use AccessorAvailable;
    private $disc;
    private $tune;
}

$audioPlayer = new AudioPlayer();
$audioPlayer->setDisc('Editors [The Back Room]')
            ->setTune('Bullets');
echo $audioPlayer->getDisc();            // "Editors [The Back Room]" outputs
echo $audioPlayer->getTune();            // "Bullets" outputs

$audioPlayer->disc('Can [Monster Movie]');
            ->tune('You Doo Right');
echo $audioPlayer->disc();               // "Can [Monster Movie]" outputs
echo $audioPlayer->tune();               // "You Doo Right" outputs
```

## Advanced Usage

### Set values collectively

```php
class AudioPlayer
{
    use AccessorAvailable;
    private $disc;
    private $tune;
}

$audioPlayer = new AudioPlayer();
// Case array
$audioPlayer->fill([
    'disc' => 'Number Girl [SAPPUKEI]',
    'tune' => 'ZEGEN VS UNDERCOVER',
]);

// Case object
$set = new \stdClass();
$set->disc = 'Joy Division [Unknown Pleasures]';
$set->tune = 'New Dawn Fades';
$audioPlayer->fill($set);
```

### Unwritable properties

If you want to exclude writing certain properties (like 'id'), you add `$gsUnwritableProps` property in the calling class.

```php
class Disc
{
    use AccessorAvailable;
    protected static $gsUnwritableProps = ['id'];
    private $id;
    private $name;
    private $size;
}

$disc = new Disc();
$disc->setId(100);                // BadMethodCallException occurs
```

Please use it if there are properties that is troublesome when written.

### Inaccessible properties

If you want to exclude certain properties, you add `$gsInaccessibleProps` property in the calling class.

```php
class AudioPlayer
{
    use AccessorAvailable;
    protected static $gsInaccessibleProps = ['tune'];
    private $disc;
    private $tune;
}

$audioPlayer = new AudioPlayer();
$audioPlayer->setDisc('Captain Beefheart [Trout Mask Replica]');
echo $audioPlayer->getDisc();            // "Captain Beefheart [Trout Mask Replica]" outputs

$audioPlayer->setTune('Ella Guru');      // BadMethodCallException occurs
$audioPlayer->getTune();                 // BadMethodCallException occurs
$audioPlayer->tune('Well');              // BadMethodCallException occurs
$audioPlayer->tune();                    // BadMethodCallException occurs
```

Please use it if there are properties that is troublesome when accessed.
In addition, if both `gsUnwritableProps` and `gsInaccessibleProps` is exists in the code, `gsInaccessibleProps` takes precedence.

<!--
## Documentation

Comming soon...
-->

## Contributing

Contributions are welcome!
This project adheres to a [Contributor Code of Conduct](./CODE_OF_CONDUCT.md). By participating in this project and its community, you are expected to uphold this code.
Please read [CONTRIBUTING](./CONTRIBUTING.md) for details.

## Copyright

The pinekta/geta-setta is copyright © [@pinekta](https://github.com/pinekta).

## License

The pinekta/getta-setta is licensed under the MIT License.
Please see [LICENSE](./LICENSE) for more information.

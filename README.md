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

<!--
## Documentation

Comming soon...
-->

## Contribute

1. Check for open issues or open a new issue for a feature request or a bug
1. Fork the repository on Github to start making your changes to the master branch (or branch off of it)
1. Write codes what is based on PSR-2.
1. Write a test which shows that the bug was fixed or that the feature works as expected
1. Send a pull request and bug me until I merge it

## License

getta-setta is licensed under the MIT license.

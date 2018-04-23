<?php

namespace Tests\Unit\Support;

use Pinekta\GetaSetta\AccessorAvailable;

/**
 * A class for 'testInaccessibleIfNotArray' test
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 */
class TestInaccessibleIfNotArray
{
    use AccessorAvailable;
    protected static $gsInaccessibleProps = 'inaccessible';
    private $inaccessible;
}

<?php

namespace Tests\Unit\Support;

use Pinekta\GetaSetta\AccessorAvailable;

/**
 * A class for 'testAccessibleIfNotInaccessibleProps' test
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 */
class TestAccessibleIfNotInaccessibleProps
{
    use AccessorAvailable;
    protected static $gsInaccessibleProps = ['inaccessible'];
    private $accessible;
}

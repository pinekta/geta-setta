<?php

namespace Tests\Unit\Support;

use Pinekta\GetaSetta\AccessorAvailable;

/**
 * A class for UnwritableProps test
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 */
class TestUnwritableProps
{
    use AccessorAvailable;
    protected static $gsUnwritableProps = ['unwritable'];
    private $writable;
    private $unwritable;
}

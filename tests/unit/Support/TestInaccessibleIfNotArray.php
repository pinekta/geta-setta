<?php

namespace Tests\Unit\Support;

use Pinekta\GetaSetta\AccessorProvider;

/**
 * A class for 'testInaccessibleIfNotArray' test
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 */
class TestInaccessibleIfNotArray
{
    use AccessorProvider;
    protected static $gsInaccessibleProps = 'inaccessible';
    private $inaccessible;
}

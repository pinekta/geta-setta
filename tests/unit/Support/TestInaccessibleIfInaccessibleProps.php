<?php

namespace Tests\Unit\Support;

use Pinekta\GetaSetta\AccessorProvider;

/**
 * A class for 'testInaccessibleIfInaccessibleProps' test
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 */
class TestInaccessibleIfInaccessibleProps
{
    use AccessorProvider;
    protected static $gsInaccessibleProps = ['inaccessible'];
    private $inaccessible;
}

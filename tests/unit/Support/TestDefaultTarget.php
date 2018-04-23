<?php

namespace Tests\Unit\Support;

use Pinekta\GetaSetta\AccessorProvider;

/**
 * A class for test
 *
 * Basically this class will be used in the test
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 */
class TestDefaultTarget
{
    use AccessorProvider;

    private $str;
    private $int;
    private $float;
    private $bool;
    private $array;
    private $object;
    private $null;

    private $name;
    private $abc;

    public $public;
    private $privatemethod;

    public function publicmethod()
    {
        return 'public';
    }

    private function privatemethod()
    {
        return 'private';
    }

    public static $static;
    protected $protected;
}

<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Unit\Support\TestDefaultTarget;
use Tests\Unit\Support\TestNotExistsInaccessibleProps;
use Tests\Unit\Support\TestAccessibleIfNotInaccessibleProps;
use Tests\Unit\Support\TestInaccessibleIfInaccessibleProps;
use Tests\Unit\Support\TestInaccessibleIfNotArray;

/**
 * A test for AccessorAvailable
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 */
class AccessorAvailableTest extends TestCase
{
    /** @var Tests\Unit\Support\TestDefaultTarget */
    private $target;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->target = new TestDefaultTarget();
    }

    /**
     * Case string property
     *
     * @test
     */
    public function testStringProperty()
    {
        $this->target->setStr('test_foo');
        $this->assertNotEquals('test_bar', $this->target->getStr());
        $this->assertEquals('test_foo', $this->target->getStr());
    }

    /**
     * Case int property
     *
     * @test
     */
    public function testIntProperty()
    {
        $this->target->setInt(1000);
        $this->assertNotEquals(1001, $this->target->getInt());
        $this->assertEquals(1000, $this->target->getInt());
    }

    /**
     * Case float property
     *
     * @test
     */
    public function testFloatProperty()
    {
        $this->target->setFloat(23.56);
        $this->assertNotEquals(12.34, $this->target->getFloat());
        $this->assertEquals(23.56, $this->target->getFloat());
    }

    /**
     * Case bool property
     *
     * @test
     */
    public function testBoolProperty()
    {
        $this->target->setBool(true);
        $this->assertNotEquals(false, $this->target->getBool());
        $this->assertEquals(true, $this->target->getBool());
    }

    /**
     * Case array property
     *
     * @test
     */
    public function testArrayProperty()
    {
        $this->target->setArray([1, 2, 3]);
        $this->assertNotEquals([1, 2, 3, 4], $this->target->getArray());
        $this->assertEquals([1, 2, 3], $this->target->getArray());
        $this->target->setArray(['foo' => 'bar']);
        $this->assertNotEquals(['foo' => 'not bar'], $this->target->getArray());
        $this->assertEquals(['foo' => 'bar'], $this->target->getArray());
    }

    /**
     * Case object property
     *
     * @test
     */
    public function testObjectProperty()
    {
        $obj = new \stdClass();
        $obj->foo = 'bar';
        $obj->bar = 'foo';

        $wrongObj = new \stdClass();
        $wrongObj->foo = 'dummy';
        $wrongObj->bar = 'dummy';

        $this->target->setObject($obj);
        $this->assertNotEquals($wrongObj, $this->target->getObject());
        $this->assertEquals($obj, $this->target->getObject());
    }

    /**
     * Case null property
     *
     * @test
     */
    public function testNullProperty()
    {
        $this->target->setNull(null);
        $this->assertNull($this->target->getNull());
    }

    /**
     * Case no matches prefix 'get' and 'set'
     *
     * @test
     */
    public function testNoMachesPrefix()
    {
        $this->target->name('pinekta');
        $this->assertNotEquals('john doe', $this->target->name());
        $this->assertEquals('pinekta', $this->target->name());
    }

    /**
     * Case below 3 length
     *
     * @test
     */
    public function testBelow3Length()
    {
        $this->target->abc('bar');
        $this->assertNotEquals('foo', $this->target->abc());
        $this->assertEquals('bar', $this->target->abc());
    }

    /**
     * Case not exists property
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function testNotExistsProperty()
    {
        $this->target->foo('bar');
    }

    /**
     * Case not exists property with 'get' prefix
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function testNotExistsPropertyWithGetPrefix()
    {
        $this->target->getFoo();
    }

    /**
     * Case not exists property with 'set' prefix
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function testNotExistsPropertyWithSetPrefix()
    {
        $this->target->setFoo('bar');
    }

    /**
     * Case 0 argument when 'set' prefix
     *
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testZeroArgumentWithSetPrefix()
    {
        $this->target->setFoo();
    }

    /**
     * Case exists public method of same name
     *
     * It is invoked as the method exists
     *
     * @test
     */
    public function testExistsPublicMethodOfSameName()
    {
        $this->target->publicmethod('foo');
        $this->assertNotEquals('bar', $this->target->publicmethod());
        $this->assertEquals('public', $this->target->publicmethod());
    }

    /**
     * Case exists private method of same name
     *
     * The magic method is invoked because it is inaccessible
     *
     * @test
     */
    public function testExistsPrivateMethodOfSameName()
    {
        $this->target->privatemethod('foo');
        $this->assertNotEquals('bar', $this->target->privatemethod());
        $this->assertEquals('foo', $this->target->privatemethod());
    }

    /**
     * Case exists public property of same name
     *
     * @test
     */
    public function testExistsPublicPropertyOfSameName()
    {
        $this->target->public('foo');
        $this->assertNotEquals('bar', $this->target->public());
        $this->assertEquals('foo', $this->target->public());
    }

    /**
     * Case exists static property
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function testExistsStaticProperty()
    {
        $this->target->static('foo');
    }

    /**
     * Case protected property (not accessable)
     *
     * @test
     */
    public function testProtectedProperty()
    {
        $this->target->setProtected('protected');
        $this->assertNotEquals('bar', $this->target->getProtected());
        $this->assertEquals('protected', $this->target->getProtected());
    }

    /**
     * Case method chain of setter
     *
     * @test
     */
    public function testSetterMethodChain()
    {
        $this->target->setProtected('protected')
                     ->setPublic('public');
        $this->assertEquals('protected', $this->target->getProtected());
        $this->assertEquals('public', $this->target->getPublic());
    }

    /**
     * Case Not exists InaccessibleProps
     *
     * @test
     */
    public function testNotExistsInaccessibleProps()
    {
        $target = new TestNotExistsInaccessibleProps();
        $target->setTest('foo');
        $this->assertNotEquals('bar', $target->getTest());
        $this->assertEquals('foo', $target->getTest());
    }

    /**
     * Case accessible property
     *
     * @test
     */
    public function testAccessibleIfNotInaccessibleProps()
    {
        $target = new TestAccessibleIfNotInaccessibleProps();
        $target->setAccessible('foo');
        $this->assertNotEquals('bar', $target->getAccessible());
        $this->assertEquals('foo', $target->getAccessible());
    }

    /**
     * Case inaccessible property
     *
     * @test
     * @expectedException \BadMethodCallException
     */
    public function testInaccessibleIfInaccessibleProps()
    {
        $target = new TestInaccessibleIfInaccessibleProps();
        $target->setInaccessible('foo');
    }

    /**
     * Case inaccessible property
     *
     * @test
     */
    public function testInaccessibleIfNotArray()
    {
        $target = new TestInaccessibleIfNotArray();
        $target->setInaccessible('foo');
        $this->assertNotEquals('bar', $target->getInaccessible());
        $this->assertEquals('foo', $target->getInaccessible());
    }
}

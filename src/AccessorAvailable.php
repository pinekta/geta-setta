<?php

namespace Pinekta\GetaSetta;

/**
 * This trait provides getter and setter.
 *
 * Using this trait
 * properties of the calling class are provided getter and setter.
 *
 * @access public
 * @author @pinekta <h03a081b@gmail.com>
 * @copyright @pinekta All Rights Reserved
 * @todo Add fill method
 */
trait AccessorAvailable
{
    /**
     * The magic method when be invoked inaccessible method.
     *
     * When property name is 'foo',
     * 'foo' property can be got with 'getFoo()'.
     * And 'foo' property can be set with 'setFoo($value)'.
     *
     * When property does not has prefix of 'get' and 'set',
     * but this trait provides the way of access.
     * 'foo' property can be got with 'foo()' too.
     * And 'foo' property can be set with 'foo($value)' too.
     *
     * @access public
     * @param string $methodName
     * @param array $arguments
     * @return mixed
     * @throws \BadMethodCallException
     * @throws \InvalidArgumentException
     */
    public function __call($methodName, array $arguments)
    {
        try {
            $methodPrefix = '';
            if (strlen($methodName) > 3) {
                $methodPrefix = substr($methodName, 0, 3);
                $propertyName = lcfirst(substr($methodName, 3));
            }

            switch ($methodPrefix) {
                case 'get':
                    if ($this->nonStaticPropertyExists($propertyName)) {
                        return $this->$propertyName;
                    }

                    throw new \BadMethodCallException();
                    break;
                case 'set':
                    if (count($arguments) == 0) {
                        throw new \InvalidArgumentException('Argument not set in [set] method.');
                    }

                    if ($this->nonStaticPropertyExists($propertyName) &&
                        $this->isWritableProperty($propertyName)) {
                        $this->$propertyName = $arguments[0];
                        return $this;
                    }

                    throw new \BadMethodCallException();
                    break;
                default:
                    if ($methodName === 'fill') {
                        return $this->getaSettaFill($arguments);
                    }

                    $propertyName = $methodName;
                    if ($this->nonStaticPropertyExists($propertyName)) {
                        if (count($arguments) == 0) {
                            return $this->$propertyName;
                        } else {
                            if ($this->isWritableProperty($propertyName)) {
                                $this->$propertyName = $arguments[0];
                                return $this;
                            }
                        }
                    }

                    throw new \BadMethodCallException();
            }
        } catch (\BadMethodCallException $e) {
            throw new \BadMethodCallException("Invalid method[{$methodName}] called. This method is not available.");
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * check if non static property
     *
     * @param string $propertyName
     * @return bool
     */
    private function nonStaticPropertyExists($propertyName)
    {
        if (array_key_exists($propertyName, get_object_vars($this))) {
            // non static property exists

            $inaccessibleProps = [];
            if (isset(static::$gsInaccessibleProps) && is_array(static::$gsInaccessibleProps)) {
                $inaccessibleProps = static::$gsInaccessibleProps;
            }
            if (in_array($propertyName, $inaccessibleProps)) {
                // case unreadable property
                return false;
            }

            return true;
        }
        if (property_exists($this, $propertyName)) {
            // static property
            return false;
        }

        // property not exists
        return false;
    }

    /**
     * check if the property is writable
     *
     * @param string $propertyName
     * @return bool
     */
    private function isWritableProperty($propertyName)
    {
        $unwritableProps = [];
        if (isset(static::$gsUnwritableProps) && is_array(static::$gsUnwritableProps)) {
            $unwritableProps = static::$gsUnwritableProps;
        }
        if (in_array($propertyName, $unwritableProps)) {
            // case unwritable property
            return false;
        }

        return true;
    }

    /**
     * fill property argument value
     *
     * @param array $arguments
     * @return mixed $this
     * @throws \InvalidArgumentException
     */
    private function getaSettaFill(array $arguments)
    {
        if (count($arguments) == 0) {
            throw new \InvalidArgumentException('Argument not set in [fill] method.');
        }

        if (is_array($arguments[0])) {
            $props = $arguments[0];
        } elseif (is_object($arguments[0])) {
            $props = json_decode(json_encode($arguments[0]), true);
        } else {
            throw new \InvalidArgumentException('Primary argument is not array or object.');
        }

        foreach ($props as $key => $value) {
            if ($this->nonStaticPropertyExists($key) &&
                $this->isWritableProperty($key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }
}

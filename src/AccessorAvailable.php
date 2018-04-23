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

                    if ($this->nonStaticPropertyExists($propertyName)) {
                        $this->$propertyName = $arguments[0];
                        return $this;
                    }

                    throw new \BadMethodCallException();
                    break;
                default:
                    $propertyName = $methodName;
                    if ($this->nonStaticPropertyExists($propertyName)) {
                        if (count($arguments) == 0) {
                            return $this->$propertyName;
                        } else {
                            $this->$propertyName = $arguments[0];
                            return $this;
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
}

<?php

namespace Pinekta\GetaSetta;

/**
 * @todo __issetと__unsetの実装
 */
trait PropertyAccessorTrait
{
    /**
     * アクセス不能プロパティget時のマジックメソッド
     *
     * @access public
     * @param string $propertyName
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __get($propertyName)
    {
        if ($this->nonStaticPropertyExists($propertyName)) {
            return $this->$propertyName;
        }

        throw new \BadMethodCallException("不正なプロパティ({$propertyName}) にアクセスされました。そのようなプロパティは存在していません。");
    }

    /**
     * アクセス不能プロパティset時のマジックメソッド
     *
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __set($propertyName, $value)
    {
        if ($this->nonStaticPropertyExists($propertyName)) {
            $this->$propertyName = $value;
            return $this;
        }

        throw new \BadMethodCallException("不正なプロパティに({$propertyName}) が値のセットが試みられました。そのようなプロパティは存在していません。");
    }
}

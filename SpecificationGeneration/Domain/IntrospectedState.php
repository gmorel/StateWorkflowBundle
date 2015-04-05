<?php

namespace SpecificationGeneration\Domain;

/**
 * @author Guillaume MOREL <guillaume.morel@verylastroom.com>
 */
class IntrospectedState
{
    const IS_ROOT = true;
    const IS_NOT_ROOT = false;

    const IS_LEAF = true;
    const IS_NOT_LEAF = false;

    /** @var string */
    private $key;

    /** @var string */
    private $name;

    /** @var bool */
    private $isRoot;

    /** @var bool */
    private $isLeaf;

    /**
     * @param string $key
     * @param string $name
     */
    public function __construct($key, $name)
    {
        $this->key = $key;
        $this->name = $name;
        $this->isRoot = self::IS_NOT_ROOT;
        $this->isLeaf = self::IS_NOT_LEAF;
    }



    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return boolean
     */
    public function isRoot()
    {
        return $this->isRoot;
    }

    /**
     * @return boolean
     */
    public function isLeaf()
    {
        return $this->isLeaf;
    }
}

<?php
namespace NeosRulez\Neos\Cart\Domain;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

trait Props
{

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @return array|bool
     */
    public function getProperties(): array|bool
    {
        return $this->properties;
    }

    /**
     * @param string $propertyName
     * @return bool
     */
    public function hasProperty(string $propertyName): bool
    {
        $properties = $this->properties;
        if(array_key_exists($propertyName, $properties)) {
            return true;
        }
        return false;
    }

    /**
     * @param string|null $propertyName
     * @return mixed
     */
    public function getProperty(string|null $propertyName = null): mixed
    {
        if($propertyName !== null) {
            if($this->hasProperty($propertyName)) {
                return $this->getProperty($propertyName);
            }
        }
        return false;
    }

    /**
     * @param array $properties
     * @return void
     */
    public function setProperties(array $properties): void
    {
        $this->properties = array_merge($this->properties, $properties);
    }

    /**
     * @param string $propertyName
     * @param mixed $propertyValue
     * @return void
     */
    public function setProperty(string $propertyName, mixed $propertyValue): void
    {
        $properties = $this->properties;
        $properties[$propertyName] = $propertyValue;
        $this->properties = $properties;
    }

}

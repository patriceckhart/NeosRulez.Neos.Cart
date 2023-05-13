<?php
namespace NeosRulez\Neos\Cart\Domain;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;

trait JsonSerialize
{

    /**
     * @Flow\Transient
     * @var array
     */
    protected $excludeFromJSON = [];

    public function jsonSerialize(): array
    {
        $array = [];
        $class = new \ReflectionClass(static::class);
        $methods = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach($methods as $method) {
            $name = $method->getName();
            if(str_starts_with($name, 'get')) {
                $property = lcfirst(substr($name, 3));
                if(in_array($property, $this->excludeFromJSON)) {
                    continue;
                }
                if($method->getNumberOfParameters() > 0) {
                    continue;
                }
                if($method->getReturnType() instanceof \ReflectionNamedType && $method->getReturnType()->getName() === 'Doctrine\Common\Collections\Collection') {
                    $array[$property] = $this->$name()->toArray();
                } else {
                    $array[$property] = $this->$name();
                }
            }
        }
        return $array;
    }

}

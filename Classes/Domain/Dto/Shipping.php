<?php
namespace NeosRulez\Neos\Cart\Domain\Dto;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use NeosRulez\Neos\Cart\Domain\JsonSerialize;
use NeosRulez\Neos\Cart\Domain\Props;

class Shipping extends AbstractDto implements \JsonSerializable
{

    /**
     * @var float
     */
    protected $price;

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return void
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @var float
     */
    protected $tax;

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    /**
     * @param float $tax
     * @return void
     */
    public function setTax(float $tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getPrice() + ($this->isNetCart ? $this->getTaxValue() : 0);
    }

    /**
     * @return float
     */
    public function getTaxValue(): float
    {
        return ($this->getPrice() / 100) * $this->getTax();
    }

}

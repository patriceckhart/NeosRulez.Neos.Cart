<?php
namespace NeosRulez\Neos\Cart\Domain\Dto;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use NeosRulez\Neos\Cart\Domain\JsonSerialize;
use NeosRulez\Neos\Cart\Domain\Props;

class Item extends AbstractDto implements \JsonSerializable
{

    /**
     * @var string
     */
    protected $sku;

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return void
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

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
     * @var float
     */
    protected $quantity;

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     * @return void
     */
    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }


    /**
     * @return float
     */
    public function getSubTotal(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getSubTotal() + ($this->isNetCart ? $this->getTaxValue() : 0);
    }

    /**
     * @return float
     */
    public function getTaxValue(): float
    {
        return ($this->getSubTotal() / 100) * $this->getTax();
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return base64_encode($this->getSku());
    }

}

<?php
namespace NeosRulez\Neos\Cart\Domain\Dto;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use NeosRulez\Neos\Cart\Domain\JsonSerialize;
use NeosRulez\Neos\Cart\Domain\Props;
use Neos\Flow\Utility\Algorithms;

class Item extends AbstractDto implements \JsonSerializable
{

    /**
     * Construct
     */
    public function __construct()
    {
        $this->identifier = Algorithms::generateRandomToken(24);
    }

    /**
     * @var string
     */
    protected $identifier = '';

    /**
     * @param string $identifier
     * @return void
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @var string
     */
    protected $sku;

    /**
     * @return string|null
     */
    public function getSku(): string|null
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
     * @return float|null
     */
    public function getPrice(): float|null
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
     * @return float|null
     */
    public function getTax(): float|null
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
     * @return float|null
     */
    public function getQuantity(): float|null
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

}

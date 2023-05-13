<?php
namespace NeosRulez\Neos\Cart\Domain\Model;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use NeosRulez\Neos\Cart\Domain\Dto\Item;
use NeosRulez\Neos\Cart\Domain\Dto\Shipping;
use NeosRulez\Neos\Cart\Domain\Dto\Summary;
use NeosRulez\Neos\Cart\Domain\JsonSerialize;

/**
 * @Flow\Scope("session")
 */
class Cart implements \JsonSerializable
{

    use JsonSerialize;

    /**
     * @var array
     */
    public $items = [];

    /**
     * @var Shipping|null
     */
    public $shipping = null;

    /**
     * @param Item $item
     * @return Item
     * @Flow\Session(autoStart = TRUE)
     */
    public function add(Item $item): Item
    {
        $this->items[$item->getIdentifier()] = $item;
        return $item;
    }

    /**
     * @param Item $item
     * @return Item
     * @Flow\Session(autoStart = TRUE)
     */
    public function update(Item $item): Item
    {
        $this->add($item);
        return $item;
    }

    /**
     * @param Item $item
     * @return Item
     */
    public function delete(Item $item): Item
    {
        unset($this->items[$item->getIdentifier()]);
        return $item;
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->items = [];
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Shipping $shipping
     * @return void
     */
    public function setShipping(Shipping $shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @return Shipping
     */
    public function getShipping(): Shipping
    {
        return $this->shipping;
    }

    /**
     * @return Summary
     */
    public function getSummary(): Summary
    {
        return new Summary($this->items, $this->shipping);
    }

}

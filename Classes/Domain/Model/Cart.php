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
     * @param string $sku
     * @return string|int|false
     */
    private function findBySku(string $sku): string|int|false
    {
        foreach ($this->items as $itemKey => $item) {
            if($item->getSku() === $sku) {
                return $itemKey;
            }
        }
        return false;
    }

    /**
     * @param string $identifier
     * @return string|int|false
     */
    private function findByIdentifier(string $identifier): string|int|false
    {
        foreach ($this->items as $itemKey => $item) {
            if($item->getIdentifier() === $identifier) {
                return $itemKey;
            }
        }
        return false;
    }

    /**
     * @param Item $item
     * @return Item
     * @Flow\Session(autoStart = TRUE)
     */
    public function add(Item $item): Item
    {
        $key = $this->findBySku($item->getSku());
        if($key !== false) {
            $currentQuantity = $this->items[$key]->getQuantity();
            $item->setQuantity($item->getQuantity() + $currentQuantity);
            $this->items[$key] = $item;
        } else {
            $this->items[$item->getIdentifier()] = $item;
        }
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
        $key = $this->findByIdentifier($item->getIdentifier());
        if($key !== false) {
            unset($this->items[$key]);
        }
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
        return array_values($this->items);
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

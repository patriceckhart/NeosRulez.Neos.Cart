<?php
namespace NeosRulez\Neos\Cart\Domain\Dto;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use NeosRulez\Neos\Cart\Domain\JsonSerialize;
use NeosRulez\Neos\Cart\Domain\Props;

class Summary extends AbstractDto implements \JsonSerializable
{

    /**
     * @var array
     */
    public $items = [];

    /**
     * @var Shipping|null
     */
    public $shipping = null;

    /**
     * Construct
     * @param array $items
     * @param Shipping|null $shipping
     */
    public function __construct(array $items, Shipping|null $shipping)
    {
        $this->items = $items;
        $this->shipping = $shipping;
    }

    /**
     * @return float
     */
    public function getSubTotal(): float
    {
        $result = 0;
        foreach ($this->items as $item) {
            $result = $result + $item->getSubTotal();
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getTaxes(): array
    {
        $result = [];
        $taxItems = [];
        $taxTotal = 0;
        foreach ($this->items as $item) {
            $taxItems[base64_encode($item->getTax())]['items'][] = [
                'tax' => $item->getTax(),
                'taxValue' => $item->getTaxValue()
            ];
            $taxItems[base64_encode($item->getTax())]['sum'] = array_key_exists('sum', $taxItems[base64_encode($item->getTax())]) ? $taxItems[base64_encode($item->getTax())]['sum'] + $item->getTaxValue() : $item->getTaxValue();
            $taxTotal = $taxTotal + $item->getTaxValue();
        }
        if(!empty($taxItems)) {
            foreach ($taxItems as $taxItem) {
                $result[] = $taxItem;
            }
        }
        return $result;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        $result = 0;
        foreach ($this->items as $item) {
            $result = $result + $item->getTotal();
        }
        return $result;
    }

}

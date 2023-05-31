<?php
namespace NeosRulez\Neos\Cart\Domain\Dto;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use NeosRulez\Neos\Cart\Domain\JsonSerialize;
use NeosRulez\Neos\Cart\Domain\Props;

class Summary extends AbstractDto implements \JsonSerializable
{

    /**
     * @Flow\InjectConfiguration(package="NeosRulez.Neos.Cart", path="slots.summary")
     * @var array
     */
    protected $summarySlots = [];

    /**
     * @Flow\Inject
     * @var ObjectManagerInterface
     */
    protected $objectManager;

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
        if($this->isNetCart === false) {
            $result = $result - $this->getTotalTaxValue();
        }
        return $this->overrule($result, 'subTotal');
    }

    /**
     * @return float
     */
    public function getTotalTaxValue(): float
    {
        $result = 0.00;
        foreach ($this->getTaxes() as $tax) {
            $result = $result + $tax['sum'];
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
        return $this->overrule($result, 'taxes');
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
        return $this->overrule($result, 'total');
    }

    /**
     * @param mixed $argument
     * @param string $action
     * @return mixed
     */
    public function overrule(mixed $argument, string $action)
    {
        $result = $argument;
        if($this->summarySlots !== null) {
            if(array_key_exists($action, $this->summarySlots)) {
                if(array_key_exists('class', $this->summarySlots[$action])) {
                    $class = $this->objectManager->get($this->summarySlots['class']);
                    $result = $class->execute($argument);
                }
            }
        }
        return $result;
    }

}

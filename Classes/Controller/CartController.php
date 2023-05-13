<?php
namespace NeosRulez\Neos\Cart\Controller;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use NeosRulez\Neos\Cart\Domain\Dto\Item;
use NeosRulez\Neos\Cart\Domain\Dto\Shipping;
use NeosRulez\Neos\Cart\Domain\Dto\Summary;
use NeosRulez\Neos\Cart\Domain\Model\Cart;

/**
 * @Flow\Scope("singleton")
 */
final class CartController extends AbstractActionController
{

    /**
     * @Flow\Inject
     * @var Cart
     */
    protected $cart;

    /**
     * @param Item $item
     * @return void
     */
    public function addItemAction(Item $item): void
    {
        $this->cart->add($item);
        $this->view->assign('value', $item);
    }

    /**
     * @param Item $item
     * @return void
     */
    public function updateItemAction(Item $item): void
    {
        $this->addItemAction($item);
        $this->view->assign('value', $item);
    }

    /**
     * @param Item $item
     * @return void
     */
    public function deleteItemAction(Item $item): void
    {
        $this->cart->delete($item);
        $this->view->assign('value', $item);
    }

    /**
     * @param Shipping $shipping
     * @return void
     */
    public function addShippingAction(Shipping $shipping): void
    {
        $this->cart->setShipping($shipping);
        $this->view->assign('value', $shipping);
    }

    /**
     * @return void
     */
    public function flushAction(): void
    {
        $this->cart->flush();
        $this->view->assign('value', 'cart flushed');
    }

    /**
     * @return void
     */
    public function itemsAction(): void
    {
        $this->view->assign('value', $this->cart->getItems());
    }

    /**
     * @return void
     */
    public function shippingAction(): void
    {
        $this->view->assign('value', $this->cart->getShipping());
    }

    /**
     * @return void
     */
    public function summaryAction(): void
    {
        $this->view->assign('value', $this->cart->getSummary());
    }

}

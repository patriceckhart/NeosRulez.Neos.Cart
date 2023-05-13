# Shopping cart for Neos Flow

A shopping cart package for Neos Flow applications.

## Installation

Just run:

```
composer require neosrulez/neos-cart
```

## Configuration

```yaml
NeosRulez:
  Neos:
    Cart:
      isNetCart: true
```

## Usage

Create a form. Whether it's a Neos Fusion form or a simple HTML form in a React component.

```html
<form>
    
<!--    Required properties for item-->
    <input type="text" name="item[quantity]" value="1" />
    <input type="hidden" name="item[sku]" value="StockKeepingUnit" />
    <input type="hidden" name="item[price]" value="25.50" />
    <input type="hidden" name="item[tax]" value="20.00" />
    
<!--    Your custom item properties-->
    <input type="text" name="item[properties][foo]" value="Foo" />
    <input type="text" name="item[properties][bar]" value="Bar" />
    <input type="text" name="item[properties][bars]" value="Bars" />
    
    <button type="submit">Add to cart</button>
    
</form>
```

```php
use NeosRulez\Neos\Cart\Domain\Model\Cart;
use NeosRulez\Neos\Cart\Domain\Model\Cart;
use NeosRulez\Neos\Cart\Domain\Dto\Shipping;

//    Inject cart session model
    /**
     * @Flow\Inject
     * @var Cart
     */
    protected $cart;
    
//    Item
    $this->cart->add($item);
    $this->cart->update($item);
    $this->cart->delete($item);
    
//    Cart
    $items = $this->cart->getItems();
    $shipping = $this->cart->getShipping();
    $summary = $this->cart->getSummary();
    
    $this->cart->flush();
    
//    Summary
    $newShipping = new Shipping();
    $newShipping->setPrice(14.90);
    $newShipping->setTax(20);
    $newShipping->setProperty('name' => 'Worldwide shipping');
    
    $this->cart->setShipping($shipping);
```

## Routes

| Description                        | Route              |
|------------------------------------|--------------------|
| Add item to cart                   | /cart/item/add     |
| Update item in cart                | /cart/item/update  |
| Delete item from cart              | /cart/item/delete  |
| Flush cart                         | /cart/flush        |
| Add shipping information and price | /cart/shipping/add |
| Get items from cart                | /cart/items        |
| Get summary                        | /cart/summary      |


## Author

* E-Mail: mail@patriceckhart.com
* URL: http://www.patriceckhart.com 

<?php
namespace NeosRulez\Neos\Cart\Domain\Dto;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use NeosRulez\Neos\Cart\Domain\JsonSerialize;
use NeosRulez\Neos\Cart\Domain\Props;

abstract class AbstractDto implements \JsonSerializable
{

    use JsonSerialize;
    use Props;

    /**
     * @Flow\InjectConfiguration(package="NeosRulez.Neos.Cart", path="isNetCart")
     * @var bool
     */
    protected $isNetCart;

}

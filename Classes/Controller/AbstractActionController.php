<?php
namespace NeosRulez\Neos\Cart\Controller;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Mvc\View\JsonView;
use Neos\Fusion\View\FusionView;

/**
 * @Flow\Scope("singleton")
 */
abstract class AbstractActionController extends ActionController
{

    protected $defaultViewObjectName = JsonView::class;

    /**
     * @var array
     */
    protected $viewFormatToObjectNameMap = [
        'html' => FusionView::class,
        'json' => JsonView::class,
    ];

}

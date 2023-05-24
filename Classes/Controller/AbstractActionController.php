<?php
namespace NeosRulez\Neos\Cart\Controller;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Mvc\View\JsonView;
use Neos\Flow\Property\TypeConverter\PersistentObjectConverter;
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

    protected function initializeAction()
    {
        $arguments = $this->request->getArguments();
        foreach ($arguments as $argumentIterator => $argument) {
            $propertyMappingConfiguration = $this->arguments[$argumentIterator]->getPropertyMappingConfiguration();
            $propertyMappingConfiguration->setTypeConverterOption(PersistentObjectConverter::class,
                PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, true );
            $propertyMappingConfiguration->setTypeConverterOption(PersistentObjectConverter::class,
                PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED, true );
            $propertyMappingConfiguration->allowAllProperties()->skipUnknownProperties();
        }
    }

}

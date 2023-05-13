<?php
namespace NeosRulez\Neos\Cart\Domain\Model;

/*
 * This file is part of the NeosRulez.Neos.Cart package.
 */

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Neos\Flow\Persistence\PersistenceManagerInterface;

/**
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\MappedSuperclass
 * @Flow\Entity
 */
abstract class AbstractModel
{

    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @Flow\Inject
     * @var PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->persistenceManager->getIdentifierByObject($this);
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->createdAt;
    }

}

<?php

namespace App\Infrastructure\Doctrine\Persistence\Listener;

use App\Domain\Interface\TimestampInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class TimestampListener
{
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof TimestampInterface) {
            $entity->setUpdatedAt(new \DateTime());
        }
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof TimestampInterface) {
            $entity->setUpdatedAt(new \DateTime('now'));

            if (!$entity->getCreatedAt()) {
                $entity->setCreatedAt(new \DateTime('now'));
            }
        }
    }
}

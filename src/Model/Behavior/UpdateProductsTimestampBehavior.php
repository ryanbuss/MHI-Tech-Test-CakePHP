<?php

declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;

class UpdateProductsTimestampBehavior extends Behavior
{
    /**
     * BeforeSave callback to update the 'updated' field.
     *
     * @param \Cake\Event\EventInterface $event The event that was triggered.
     * @param \Cake\ORM\Entity $entity The entity being saved.
     * @param \ArrayObject $options Additional options for the save operation.
     * @return void
     */
    public function beforeSave(EventInterface $event, Entity $entity, \ArrayObject $options): void
    {
        // Only update 'updated' field if the entity is NOT a new database entry e.g. not a new product
        if (!$entity->isNew()) {
            $entity->set('updated', date('Y-m-d H:i:s'));
        }
    }
}

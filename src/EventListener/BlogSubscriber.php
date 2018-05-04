<?php
/**
 * Created by PhpStorm.
 * User: jneves
 * Date: 26/04/2018
 * Time: 15:17
 */

namespace App\EventListener;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\BlogPost;

class BlogSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postDrafted',
            'postPersist',
        );
    }

    public function postDrafted(LifecycleEventArgs  $args){
        $this->index($args);
    }
    
    public function postPersist(LifecycleEventArgs  $args){
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Product) {
            $entityManager = $args->getEntityManager();
            // ... do something with the Product
        }
    }
}
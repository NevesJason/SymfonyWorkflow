<?php

namespace App\EventSubscriber;


use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;

class WorkflowLogger implements EventSubscriberInterface

{
    public $logger ;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onLeave(Event $event)
    {
        dump('onleave');
        $this->logger->alert(sprintf(
            'Blog post (id: "%s") performed transaction "%s" from "%s" to "%s"',
            $event->getSubject()->getId(),
            $event->getTransition()->getName(),
            implode(', ', array_keys($event->getMarking()->getPlaces())),
            implode(', ', $event->getTransition()->getTos())
        ));
    }
    public function guardReview(GuardEvent $event)
    {
        /** @var \App\Entity\BlogPost $post */
        $post = $event->getSubject();
        $title = $post->getTitle();
        dump($title);
        $this->logger->debug(sprintf(
            'Guard post (id: "%s") performed transaction "%s" from "%s" to "%s"',
            $event->getSubject()->getId(),
            $event->getTransition()->getName(),
            implode(', ', array_keys($event->getMarking()->getPlaces())),
            implode(', ', $event->getTransition()->getTos())
        ));
        if (empty($title)) {
            // Posts with no title should not be allowed
            $event->setBlocked(true);
        }
    }


    public static function getSubscribedEvents()
    {
        return array(
            'workflow.publishing.leave' => 'onLeave',
            'workflow.publishing.guard.publish' => 'guardReview',
        );
    }

}

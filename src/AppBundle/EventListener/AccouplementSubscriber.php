<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 20/03/2017
 * Time: 15:42
 */

namespace AppBundle\EventListener;

use AppBundle\GlobalEvents;
use AppBundle\Event\AccouplementEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AccouplementSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents() {
        return array(
            GlobalEvents::ACCOUPLEMENT => array('verificationParent', 250)
        );
    }

    public function verificationParent(AccouplementEvent $event) {
        if($event->getParent1()->getName() == $event->getParent2()->getName()) {
            die("yo");
        }
    }

}
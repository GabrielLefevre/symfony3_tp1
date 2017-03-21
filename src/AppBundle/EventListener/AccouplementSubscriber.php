<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 20/03/2017
 * Time: 15:42
 */

namespace AppBundle\EventListener;

use AppBundle\GlobalEvents;
use AppBundle\Entity\Animaux;
use AppBundle\Event\AccouplementEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class AccouplementSubscriber implements EventSubscriberInterface
{
    private $em;
    private $animal;
    private $session;

    function __construct(EntityManager $em, Animaux $animal, $s) {
        $this->em = $em;
        $this->animal = $animal;
        $this->session = $s;
    }


    public static function getSubscribedEvents() {
        return array(
            GlobalEvents::ACCOUPLEMENT => array('verificationParent', 250)
        );
    }

    public function verificationParent(AccouplementEvent $event) {
        if($event->getParent1()->getName() == $event->getParent2()->getName()) {
            $this->session->getFlashBag()->add(
                'warning',
                $event->getParent1()->getName().' ne peut pas se reproduire seul'
            );
        }
        else if($event->getParent1()->getType() != $event->getParent2()->getType()) {
            $this->session->getFlashBag()->add(
                'warning',
                'les animaux ne sont pas du même type. '.$event->getParent1()->getName().' est un '.$event->getParent1()->getType().' et '.$event->getParent2()->getName().' est un '.$event->getParent2()->getType().'.'
            );
        }
        else if($event->getParent1()->getSexe() == $event->getParent2()->getSexe()) {
            $this->session->getFlashBag()->add(
                'warning',
                'Les deux animaux sont des '.$event->getParent1()->getSexe()
            );
        }
       else {
            $this->createBebe($event);
       }
    }

    public function createBebe(AccouplementEvent $event) {
        $bebe = clone $this->animal;
        $bebe->setName($event->getParent1()->getName().$event->getParent2()->getName().rand(0,1000));
        $bebe->setAge(0);
        $bebe->setType($event->getParent1()->getType());
        $bebe->setUser($event->getParent1()->getUser());
        $bebe->setDateTime(new \DateTime("now"));
        $bebe->setPhoto($event->getPhoto());
        $sexerandom = rand(0,1);
        if($sexerandom == 0) {
            $bebe->setSexe("Femelle");
        }
        else {
            $bebe->setSexe("Male");
        }
        $this->session->getFlashBag()->add(
            'success',
            'votre bébé '.$bebe->getName().' est né. Félicitations !'
        );
        $this->em->persist($bebe);
        $this->em->flush();
        }

}
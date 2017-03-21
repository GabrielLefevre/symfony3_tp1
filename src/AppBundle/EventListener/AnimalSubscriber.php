<?php

/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 16/03/2017
 * Time: 08:37
 */
namespace AppBundle\EventListener;

use AppBundle\Entity\Animaux;
use AppBundle\GlobalEvents;
use AppBundle\Event\AnimalEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AnimalSubscriber implements EventSubscriberInterface
{
    private $em;


    function __construct(EntityManager $em) {
        $this->em = $em;

    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            GlobalEvents::ANIMAL_ADD => array('addAnimal', 250),
            GlobalEvents::ANIMAL_UPDATE => array('updateAnimal', 250),
            GlobalEvents::ANIMAL_DELETE => array('deleteAnimal', 250)
        );
    }

 /*   public function verifAdd(AnimalEvent $event)
    {
        if ($event->getAnimal1()->getName() != $event->getAnimal2()->getName()) {
            $this->accouplement->setParent1($event->getAnimal1());
            $this->accouplement->setParent2($event->getAnimal2());
            $verification = $this->accouplement->verificationParents();
            if ($verification == true) {
                $event->setAnimal1($this->accouplement->createBebe());
                $event->setReponse("Votre bébé est né");
            } else {
                $event->setReponse("Ces animaux ne sont pas compatibles");
                $event->setValidation(false);
            }
        } else {
            $event->setReponse("Ces animaux ne sont pas compatibles");
            $event->setValidation(false);
        }
    }
*/

    public function addAnimal(AnimalEvent $event)
    {
        $this->em->persist($event->getAnimal());
        $this->em->flush();
    }

    public function updateAnimal (AnimalEvent $event) {
        $event->getAnimal()->updateExtensionPhoto();
        $this->em->flush();
    }


}
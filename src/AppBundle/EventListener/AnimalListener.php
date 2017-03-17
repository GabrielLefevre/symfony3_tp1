<?php

/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 16/03/2017
 * Time: 08:37
 */
namespace AppBundle\EventListener;


use AppBundle\Event\AnimalEvent;
use AppBundle\Validateur\Accouplement;
use Symfony\Component\HttpFoundation\Response;

class AnimalListener
{

    protected $accouplement;

    public function __construct(Accouplement $accouplement)
    {
        $this->accouplement = $accouplement;
    }


    public function verifAdd(AnimalEvent $event) {
        if ($event->getAnimal1()->getName() != $event->getAnimal2()->getName()) {
            $this->accouplement->setParent1($event->getAnimal1());
            $this->accouplement->setParent2($event->getAnimal2());
            $verification = $this->accouplement->verificationParents();
            if($verification == true) {
                $event->setAnimal1($this->accouplement->createBebe());
                $event->setReponse("Votre bébé est né");
            }
            else {
                $event->setReponse("Ces animaux ne sont pas compatibles");
                $event->setValidation(false);
            }
        }
        else {
            $event->setReponse("Ces animaux ne sont pas compatibles");
            $event->setValidation(false);
        }
    }


}
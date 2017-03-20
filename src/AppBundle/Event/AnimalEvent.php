<?php

/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 16/03/2017
 * Time: 08:37
 */
namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;


class AnimalEvent extends Event
{

    private $animal;

    public function getAnimal() {
        return $this->animal;
    }

    public function setAnimal($animal) {
        return $this->animal = $animal;
    }
}

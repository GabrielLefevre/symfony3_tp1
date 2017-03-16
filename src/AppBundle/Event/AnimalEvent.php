<?php

/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 16/03/2017
 * Time: 08:37
 */
namespace AppBundle\Event;

use AppBundle\Entity\Animaux;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;


class AnimalEvent extends Event
{

    protected $animal1;
    protected $animal2;
    protected $reponse = " ";
    protected $validation = true;


    public function getAnimal1() {
        return $this->animal1;
    }

    public function setAnimal1($animal) {
        return $this->animal1 = $animal;
    }

    public function getAnimal2() {
        return $this->animal2;
    }

    public function setAnimal2($animal) {
        return $this->animal2 = $animal;
    }

    public function getReponse()
    {
        return $this->reponse;
    }

    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }

    /**
     * @return bool
     */
    public function isValidation()
    {
        return $this->validation;
    }

    /**
     * @param bool $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }



}
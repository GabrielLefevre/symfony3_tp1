<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 20/03/2017
 * Time: 15:39
 */

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class AccouplementEvent extends Event
{
    private $parent1;
    private $parent2;

    /**
     * @return mixed
     */
    public function getParent1()
    {
        return $this->parent1;
    }

    /**
     * @param mixed $parent1
     */
    public function setParent1($parent1)
    {
        $this->parent1 = $parent1;
    }

    /**
     * @return mixed
     */
    public function getParent2()
    {
        return $this->parent2;
    }

    /**
     * @param mixed $parent2
     */
    public function setParent2($parent2)
    {
        $this->parent2 = $parent2;
    }

    public function setData($data) {
       if(!is_array($data)) {
           throw new \InvalidArgumentException("Data n'est pas un array");
       }
       if(!array_key_exists("Animal1", $data)) {
           throw new \InvalidArgumentException("Parent1 n'existe pas");
       }
        if(!array_key_exists("Animal2", $data)) {
            throw new \InvalidArgumentException("Parent2 n'existe pas");
        }
        $this->parent1 = $data["Animal1"];
       $this->parent2 = $data["Animal2"];
    }

    
}
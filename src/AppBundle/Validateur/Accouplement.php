<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 09/03/2017
 * Time: 09:21
 */

namespace AppBundle\Validateur;


use AppBundle\Entity\Animaux;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class Accouplement
{
    private $bebe;
    private $em;
    private $parent1;
    private $parent2;
    private $user;
    function __construct(Animaux $bebe, EntityManager $em, TokenStorage $token ) {
        $this->bebe=$bebe;
        $this->em=$em;
        $this->user = $token->getToken()->getUser();

    }

    public function setParent1( Animaux $p1) {
        $this->parent1=$p1;
    }

    public function getParent1() {
        return $this->parent1;
    }

    public function getParent2() {
        return $this->parent2;
    }

    public function setParent2( Animaux $p2) {
        $this->parent2=$p2;
    }

    public function getBebe() {
        return $this->bebe;
    }

    public function verificationParents() {
        if($this->parent1->getAge()<3 || $this->parent2->getAge()<3 ) {
            return false;
        }
        else if ($this->parent1->getType() != $this->parent2->getType()) {
            return false;
        }
        else if ($this->parent1->getSexe() == $this->parent2->getSexe()) {
            return false;
        }
        else {
            return true;
        }
    }

    public function createBebe() {
        $bebe = clone $this->bebe;
        $bebe->setName($this->createNameBebe());
        $bebe->setAge(0);
        $bebe->setType($this->parent1->getType());
        $bebe->setUser($this->parent1->getUser());
        $sexerandom = rand(0,1);
        if($sexerandom == 0) {
            $bebe->setSexe("Femelle");
        }
        else {
            $bebe->setSexe("Male");
        }
        return $bebe;
    }

    public function createNameBebe() {
        return $this->parent1->getName().$this->parent2->getName().rand(0,1000);
    }
//foundation autoprefixer

}
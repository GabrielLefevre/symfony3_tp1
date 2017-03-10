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

class Accouplement
{
    private $animaux;
    private $em;
    private $parent1;
    private $parent2;
    private $reponse="";

    function __construct(Animaux $a1, EntityManager $em) {
        $this->animaux=$a1;
        $this->em=$em;

    }

    public function setParent1( Animaux $p1) {
        $this->parent1=$p1;
    }

    public function setParent2( Animaux $p2) {
        $this->parent2=$p2;
    }

    public function verificationParents() {
        if($this->parent1->getName() == $this->parent2->getName()) {
            $this->reponse= $this->parent1->getName()." ne peut pas se reproduire sans son partenaire.";
            // all
        }
        else if($this->parent1->getAge()<3 || $this->parent2->getAge()<3 ) {
            $this->reponse="L'un des animaux est trop jeune, ils doivent avoir au moins 3ans pour se reproduire. ".$this->parent1->getName()." à ".$this->parent1->getAge()."ans, ".$this->parent2->getName()." à ".$this->parent2->getAge()."ans";
            // tata + toto
        }
        else if ($this->parent1->getType() != $this->parent2->getType()) {
            $this->reponse="Les deux animaux ne sont pas du même type.".$this->parent1->getName()." est un(e) ".$this->parent1->getType().", ".$this->parent2->getName()." est un(e) ".$this->parent2->getType();
            // tata + babar
        }
        else if ($this->parent1->getSexeMasc() == $this->parent2->getSexeMasc()) {
            $this->reponse="Les deuxs animaux sont de même sexe.";
            // tata+tutu
        }
        else {

            $animaux = $this->createBebe();

            $this->reponse = "Votre bébé est née.";
            $this->em->persist($animaux);
            $this->em->flush($animaux);
        }
        return $this->reponse;
    }

    public function createBebe() {
        $animaux = clone $this->animaux;
        $animaux->setName($this->createNameBebe());
        $animaux->setAge(0);
        $animaux->setType($this->parent1->getType());
        $sexerandom = (bool)rand(0,1);
        $animaux->setSexeMasc($sexerandom);
        return $animaux;
    }

    public function createNameBebe() {
        return $this->parent1->getName().$this->parent2->getName().rand(0,1000);
    }
//foundation autoprefixer

}
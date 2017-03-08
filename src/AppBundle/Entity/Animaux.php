<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Animaux
 *
 * @ORM\Table(name="animaux")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnimauxRepository")
 */
class Animaux
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sexeMasc", type="boolean")
     */
    private $sexeMasc;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Animaux
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Animaux
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Animaux
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sexeMasc
     *
     * @param boolean $sexeMasc
     *
     * @return Animaux
     */
    public function setSexeMasc($sexeMasc)
    {
        $this->sexeMasc = $sexeMasc;

        return $this;
    }

    /**
     * Get sexeMasc
     *
     * @return boolean
     */
    public function getSexeMasc()
    {
        return $this->sexeMasc;
    }

    public function __toString() {
        return $this->name;
    }
}

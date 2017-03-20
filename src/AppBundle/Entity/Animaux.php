<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Animaux
 *
 * @ORM\Table(name="animaux")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnimauxRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @Assert\Type("string")
     * @Assert\NotBlank(message="donnez un nom à votre animal.")
     * @Assert\Length(
     *     min=3,
     *     max=40,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.")
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     * @Assert\Type("string")
     * @Assert\Choice(
     *     choices = { "Male", "Femelle" },
     *     message = "Choose a valid gender.")
     *
     * @ORM\Column(name="sexe", type="string")
     */
    private $sexe;

    /**
     * @var int
     * @Assert\Type("integer")
     * @Assert\NotNull()
     * @Assert\Range(
     *      min = 0,
     *      max = 25,
     *      minMessage = " il faut au minimum un animal âgé de {{ limit }} année. ",
     *      maxMessage = "votre animal ne peut pas avoir plus de {{ limit }} ans."
     * )
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeAnimaux")
     *
     * @ORM\JoinColumn(name="type_animaux", referencedColumnName="id")
     */
    private $type;


    /**
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="animaux")
     *
     * @ORM\JoinColumn(name="fos_user", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @Assert\NotBlank(message="Image necessaire", groups={"create"})
     * @Assert\Image(
     *      minWidth = 20,
     *     maxWidth = 4000,
     *     minHeight = 20,
     *     maxHeight = 4000,
     *
     * )
     */
    private $photo;

    /**
     *@ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $extension;


    /**
     * @ORM\column(type="datetime")
     * @Assert\DateTime()
     */
    private $dateTime;

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
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Animaux
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Animaux
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $photoName
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime( \DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }


    public function getWebPath() {
        return $this->getUploadDir().'/'.$this->id.'.'.$this->extension;
    }

    public function getUploadRootDir() {
        return __DIR__.'../../web/'.$this->getUploadDir();
    }

    public function getUploadDir() {
        return 'uploads/images_animaux_entity';
    }

    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function movePhoto() {
        if($this->photo != null) {
            $this->photo->move($this->getUploadDir(),$this->id.'.'.$this->extension);
            $this->photo = null;
        }
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     */public function updateExtensionPhoto() {
         if ($this->photo != null ) {
             $this->extension =$this->photo->guessExtension();
         }
    }




    public function __toString() {
        return $this->name;
    }
}

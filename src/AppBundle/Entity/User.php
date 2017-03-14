<?php
/**
 * Created by PhpStorm.
 * User: DEV2
 * Date: 10/03/2017
 * Time: 10:02
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     *
     *
     */
    private $animaux;


    /**
     *@ORM\ManyToMany(targetEntity="AppBundle\Entity\TypeAnimaux")
     * @ORM\JoinTable(name="user_type",
     *      joinColumns={@ORm\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     * 
     */
    private $type;




    public function __construct()
    {
        parent::__construct();
        // your own logic
    }



    /**
     * Add type
     *
     * @param \AppBundle\Entity\TypeAnimaux $type
     *
     * @return User
     */
    public function addType(\AppBundle\Entity\TypeAnimaux $type)
    {
        $this->type[] = $type;

        return $this;
    }

    /**
     * Remove type
     *
     * @param \AppBundle\Entity\TypeAnimaux $type
     */
    public function removeType(\AppBundle\Entity\TypeAnimaux $type)
    {
        $this->type->removeElement($type);
    }

    /**
     * Get type
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getType()
    {
        return $this->type;
    }

}

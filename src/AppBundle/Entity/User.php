<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(type="string")
     */
    private $firstname;


    /**
     * @ORM\Column(type="string")
     */
    private $lastname;

    /**
    * One User has many Games
    * @ORM\OneToMany(targetEntity="Game", mappedBy="uploadedBy")
    */
    private $games;

    /**
     * Many Users have Many Upvoters.
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="upvoters")
     */
    private $upvotedgames;

    /**
     * Many Users have Many Downvoters.
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="downvoters")
     */
    private $downvotedgames;


    public function __construct() {
        $this->games = new ArrayCollection();
        $this->upvotedgames = new ArrayCollection();
        $this->downvotedgames = new ArrayCollection();

    }


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
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @param User $currentUser
     * @return bool
     */
    public function isUserAllowed(User $currentUser)
    {
        if($this->getId() === $currentUser->getId()){
            return true;
        }
        else {
            return false;
        }
    }



}


<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="Game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameRepository")
 */
class Game
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=255)
     */
    private $year;

    /**
     * @var int
     * Many Games have one Genre
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="games")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     *
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255)
     */
    private $cover;

    /**
     * @var int
     * Many Games have one User.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="games")
     * @ORM\JoinColumn(name="uploaded_by_id", referencedColumnName="id")
     * @ORM\JoinColumn(name="username", referencedColumnName="username")
     * @return int
     */
    private $uploadedBy;

    /**
     * @var int
     *
     * @ORM\Column(name="upvotes", type="integer")
     */
    private $upvotes;

    /**
     * @var int
     *
     * @ORM\Column(name="downvotes", type="integer")
     */
    private $downvotes;

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
     * Set title
     *
     * @param string $title
     *
     * @return Game
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set year
     *
     * @param string $year
     *
     * @return Game
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set genre
     *
     * @param integer $genre
     *
     * @return Game
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return int
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Game
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set cover
     *
     * @param string $cover
     *
     * @return Game
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set uploadedBy
     *
     * @param integer $uploadedBy
     *
     * @return Game
     */
    public function setUploadedBy($uploadedBy)
    {
        $this->uploadedBy = $uploadedBy;

        return $this;
    }

    /**
     * Get uploadedBy
     *
     * @return int
     */
    public function getUploadedBy()
    {
        return $this->uploadedBy;
    }

    /**
     * Set upvotes
     *
     * @param integer $upvotes
     *
     * @return Game
     */
    public function setUpvotes($upvotes)
    {
        $this->upvotes = $upvotes;

        return $this;
    }

    /**
     * Get upvotes
     *
     * @return int
     */
    public function getUpvotes()
    {
        return $this->upvotes;
    }

    /**
     * @return int
     */
    public function getDownvotes()
    {
        return $this->downvotes;
    }

    /**
     * @param int $downvotes
     */
    public function setDownvotes($downvotes)
    {
        $this->downvotes = $downvotes;
    }


}


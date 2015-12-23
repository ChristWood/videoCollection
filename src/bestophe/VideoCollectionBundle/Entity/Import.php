<?php

namespace bestophe\VideoCollectionBundle\Entity;
use bestophe\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Import
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="bestophe\VideoCollectionBundle\Entity\ImportRepository")
 */
class Import
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userId;
    
     /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="date", nullable=true)
     */
    private $releaseDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="tmdbId", type="integer", nullable=true)
     */
    private $tmdbId;

    /**
     * @var integer
     *
     * @ORM\Column(name="imdbId", type="integer", nullable=true)
     */
    private $imdbId;

    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Import
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
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     * @return Import
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime 
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set tmdbId
     *
     * @param integer $tmdbId
     * @return Import
     */
    public function setTmdbId($tmdbId)
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }

    /**
     * Get tmdbId
     *
     * @return integer 
     */
    public function getTmdbId()
    {
        return $this->tmdbId;
    }

    /**
     * Set imdbId
     *
     * @param integer $imdbId
     * @return Import
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * Get imdbId
     *
     * @return integer 
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Import
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}

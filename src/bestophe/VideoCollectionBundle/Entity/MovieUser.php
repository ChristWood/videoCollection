<?php

namespace bestophe\VideoCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use bestophe\VideoCollectionBundle\Entity\Movie;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * MovieUser
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="bestophe\VideoCollectionBundle\Entity\MovieUserRepository")
 * @ORM\HasLifecycleCallbacks
 * @ExclusionPolicy("all")
 */
class MovieUser {
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $id;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="bestophe\VideoCollectionBundle\Entity\Movie", inversedBy="movie_user", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     */
    private $movie;   
    
       
    /**
     *
     * @ORM\ManyToOne(targetEntity="bestophe\VideoCollectionBundle\Entity\Media", inversedBy="movie_media", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $media;
    
    /**
     * @var integer
     * 
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $userId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $comment;
    
    /**
     * @var integer
     * 
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $rating;

    /**
     * @var boolean
     *
     *
     * @ORM\Column(name="favorite", type="boolean", nullable=true)
     */
    private $favorite;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Expose
     * @Serializer\Groups({"elastica"})
     */
    private $updated;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param bestophe\UserBundle\Entity\User $user
     * @return movie_user
     */
//    public function setUser(User $user = null) {
//        $this->user = $user;
//
//        return $this;
//    }

    /**
     * Get user
     *
     * @return bestophe\UserBundle\Entity\User
     */
//    public function getUser() {
//        return $this->user;
//    }
    
/**
     * Set movie
     *
     * @param bestophe\VideoCollectionBundle\Entity\Movie $movie
     * @return MovieUser
     */
    public function setMovie(Movie $movie)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return bestophe\VideoCollectionBundle\Entity\Movie $movie
     */
    public function getMovie()
    {
        return $this->movie;
    }


    /**
     * Set media
     *
     * @param string $media
     * @return MovieUserAsso
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return 
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return integer
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set favorite
     *
     * @param boolean $favorite
     * @return boolean
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get favorite
     *
     * @return boolean 
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    
    
     /**
     * Set created
     *
     * @param \DateTime $created
     * @return MovieUserAsso created at
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return MovieUser updated at
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated() {
        return $this->updated;
    }

    

    /**
     * Set userId
     *
     * @param integer $userId
     * @return MovieUser
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

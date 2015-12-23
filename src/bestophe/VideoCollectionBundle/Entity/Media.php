<?php

namespace bestophe\VideoCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use bestophe\VideoCollectionBundle\Entity\MovieUser;

/**
 * Media
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="bestophe\VideoCollectionBundle\Entity\MediaRepository")
 */
class Media
{
    
    /**
     * @ORM\OneToMany(targetEntity="bestophe\VideoCollectionBundle\Entity\MovieUser", mappedBy="media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $movie_media;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;
    
    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;


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
     * Set name
     *
     * @param string $name
     * @return Media
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
     * Constructor
     */
    public function __construct()
    {
        $this->movie_media = new ArrayCollection();
    }

    /**
     * Add movie_media
     *
     * @param MovieUser $movieMedia
     * @return Media
     */
    public function addMovieMedia(MovieUser $movieMedia)
    {
        $this->movie_media[] = $movieMedia;

        return $this;
    }

    /**
     * Remove movie_media
     *
     * @param MovieUser $movieMedia
     */
    public function removeMovieMedia(MovieUser $movieMedia)
    {
        $this->movie_media->removeElement($movieMedia);
    }

    /**
     * Get movie_media
     *
     * @return Collection 
     */
    public function getMovieMedia()
    {
        return $this->movie_media;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Media
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Media
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}

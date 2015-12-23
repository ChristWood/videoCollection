<?php

namespace bestophe\VideoCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use bestophe\VideoCollectionBundle\Entity\MovieCast;
use bestophe\VideoCollectionBundle\Entity\MovieCrew;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="bestophe\VideoCollectionBundle\Entity\PersonRepository")
 */
class Person {

    /**
     * @ORM\OneToMany(targetEntity="bestophe\VideoCollectionBundle\Entity\MovieCast", mappedBy="person", cascade={"persist","remove"},fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $movie_cast;

    /**
     * @ORM\OneToMany(targetEntity="bestophe\VideoCollectionBundle\Entity\MovieCrew", mappedBy="person", cascade={"persist","remove"},fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $movie_crew;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="aka", type="simple_array", length=255, nullable=true)
     */
    private $aka;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deathday", type="date", nullable=true)
     */
    private $deathday;

    /**
     * @var string
     *
     * @ORM\Column(name="homepage", type="string", length=255, nullable=true)
     */
    private $homepage;

    /**
     * @var string
     *
     * @ORM\Column(name="placeOfBirth", type="string", length=255, nullable=true)
     */
    private $placeOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="profilePath", type="string", length=255, nullable=true)
     */
    private $profilePath;

    /**
     * @var boolean
     *
     * @ORM\Column(name="adult", type="boolean")
     */
    private $adult;

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

    public function __construct() {
        $this->movie_cast = new ArrayCollection();
        $this->movie_crew = new ArrayCollection();
    }

    public function hydrate($people) {
        $this->setId($people->getId())
                ->setAdult($people->getAdult())
                ->setAka($people->getAlsoKnownAs())
                ->setName($people->getName())
                ->setBirthday($people->getBirthday())
                ->setDeathday($people->getDeathday())
                ->setPlaceOfBirth($people->getPlaceOfBirth())
                ->setHomepage($people->getHomepage())
                ->setProfilePath($people->getProfilePath());
    }

    public function update($people) {
        $this->setAdult($people->getAdult())
                ->setAka($people->getAlsoKnownAs())
                ->setName($people->getName())
                ->setBirthday($people->getBirthday())
                ->setDeathday($people->getDeathday())
                ->setPlaceOfBirth($people->getPlaceOfBirth())
                ->setHomepage($people->getHomepage())
                ->setProfilePath($people->getProfilePath());
    }

    /**
     * Add movie_cast 
     * 
     * @param bestophe\VideoCollectionBundle\Entity\MovieCast $movie_cast
     * @return Person
     */
    public function addMovieCast(MovieCast $movie_cast) {
        $this->movie_cast[] = $movie_cast;
        $movie_cast->setPerson($this);
        return $this;
    }

    /**
     * Remove movie_cast
     *
     * @param bestophe\VideoCollectionBundle\Entity\MovieCast $movie_cast
     */
    public function removeMovieCast(MovieCast $movie_cast) {
        $this->movie_cast->removeElement($movie_cast);
    }

    /**
     * Get movie_cast 
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovieCast() {
        return $this->movie_cast;
    }

    /**
     * Add movie_crew 
     * 
     * @param bestophe\VideoCollectionBundle\Entity\MovieCrew $movie_crew
     * @return Person
     */
    public function addMovieCrew(MovieCrew $movie_crew) {
        $this->movie_crew[] = $movie_crew;
        $movie_crew->setPerson($this);
        return $this;
    }

    /**
     * Remove movie_crew
     *
     * @param bestophe\VideoCollectionBundle\Entity\MovieCrew $movie_crew
     */
    public function removeMovieCrew(MovieCrew $movie_crew) {
        $this->movie_crew->removeElement($movie_crew);
    }

    /**
     * Get movie_crew 
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovieCrew() {
        return $this->movie_crew;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Person
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set aka
     *
     * @param string $aka
     * @return Person
     */
    public function setAka($aka) {
        $this->aka = $aka;

        return $this;
    }

    /**
     * Get aka
     *
     * @return string 
     */
    public function getAka() {
        return $this->aka;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Person
     */
    public function setBirthday($birthday) {
        
        if (!$birthday instanceof \DateTime && !empty($birthday)) {
            $birthday = new \DateTime($birthday);
        }
        if (empty($birthday)) {
            $birthday = null;
        }
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday() {
        return $this->birthday;
    }

    /**
     * Set deathday
     *
     * @param \DateTime $deathday
     * @return Person
     */
    public function setDeathday($deathday) {

        if (!$deathday instanceof \DateTime && !empty($deathday)) {
            $deathday = new \DateTime($deathday);
        }
        if (empty($deathday)) {
            $deathday = null;
        }
        $this->deathday = $deathday;
        return $this;
    }

    /**
     * Get deathday
     *
     * @return \DateTime 
     */
    public function getDeathday() {
        return $this->deathday;
    }

    /**
     * Set homepage
     *
     * @param string $homepage
     * @return Person
     */
    public function setHomepage($homepage) {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return string 
     */
    public function getHomepage() {
        return $this->homepage;
    }

    /**
     * Set placeOfBirth
     *
     * @param string $placeOfBirth
     * @return Person
     */
    public function setPlaceOfBirth($placeOfBirth) {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    /**
     * Get placeOfBirth
     *
     * @return string 
     */
    public function getPlaceOfBirth() {
        return $this->placeOfBirth;
    }

    /**
     * Set adult
     *
     * @param boolean $adult
     * @return Person
     */
    public function setAdult($adult) {
        $this->adult = $adult;

        return $this;
    }

    /**
     * Get adult
     *
     * @return boolean 
     */
    public function getAdult() {
        return $this->adult;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Person
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Person
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
     * @return Person
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
     * Set profilePath
     *
     * @param string $profilePath
     * @return Person
     */
    public function setProfilePath($profilePath) {
        $this->profilePath = $profilePath;

        return $this;
    }

    /**
     * Get profilePath
     *
     * @return string 
     */
    public function getProfilePath() {
        return $this->profilePath;
    }

}

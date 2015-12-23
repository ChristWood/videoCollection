<?php

namespace bestophe\VideoCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use bestophe\VideoCollectionBundle\Entity\Movie;
use bestophe\VideoCollectionBundle\Entity\Person;

/**
 * MovieCast
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="bestophe\VideoCollectionBundle\Entity\MovieCastRepository")
 */
class MovieCast {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="bestophe\VideoCollectionBundle\Entity\Person", inversedBy="movie_cast", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="bestophe\VideoCollectionBundle\Entity\Movie", inversedBy="movie_cast", cascade={"persist"})
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     */
    private $movie;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", nullable=false)
     */
    private $role;

    /**
     * @var integer
     *
     * @ORM\Column(name="orderNb", type="integer", nullable=true)
     */
    private $orderNb;

    public function hydrate($member) {
        $this->setRole($member->getCharacter())
                ->setOrderNb($member->getOrder());
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
     * Set orderNb
     *
     * @param integer $orderNb
     * @return MovieCast
     */
    public function setOrderNb($orderNb) {
        $this->orderNb = $orderNb;

        return $this;
    }

    /**
     * Get orderNb
     *
     * @return integer 
     */
    public function getOrderNb() {
        return $this->orderNb;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return MovieCast
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Set person
     *
     * @param bestophe\VideoCollectionBundle\Entity\Person $person
     * @return movie_cast
     */
    public function setPerson(Person $person) {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return bestophe\VideoCollectionBundle\Entity\Person $person
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * Set movie
     *
     * @param bestophe\VideoCollectionBundle\Entity\Movie $movie
     * @return MovieUser
     */
    public function setMovie(Movie $movie) {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return bestophe\VideoCollectionBundle\Entity\Movie $movie
     */
    public function getMovie() {
        return $this->movie;
    }

}

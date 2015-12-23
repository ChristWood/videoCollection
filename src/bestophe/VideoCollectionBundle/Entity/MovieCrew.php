<?php

namespace bestophe\VideoCollectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use bestophe\VideoCollectionBundle\Entity\Movie;
use bestophe\VideoCollectionBundle\Entity\Person;

/**
 * MovieCrew
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="bestophe\VideoCollectionBundle\Entity\MovieCrewRepository")
 */
class MovieCrew {

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
     * @ORM\ManyToOne(targetEntity="bestophe\VideoCollectionBundle\Entity\Person", inversedBy="movie_crew", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="bestophe\VideoCollectionBundle\Entity\Movie", inversedBy="movie_crew", cascade={"persist"})
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     */
    private $movie;

    /**
     * @var string
     *
     * @ORM\Column(name="department", type="string", nullable=true)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="job", type="string", nullable=true)
     */
    private $job;

    public function hydrate($member) {
        $this->setDepartment($member->getDepartment())
                ->setJob($member->getJob());
    }

    /**
     * Set id
     *
     * @return MovieCrew 
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
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

    /**
     * Set department
     *
     * @param string $department
     * @return MovieCrew
     */
    public function setDepartment($department) {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string 
     */
    public function getDepartment() {
        return $this->department;
    }

    /**
     * Set job
     *
     * @param string $job
     * @return MovieCrew
     */
    public function setJob($job) {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob() {
        return $this->job;
    }

}

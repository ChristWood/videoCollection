<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Manager\BaseManager;
use bestophe\VideoCollectionBundle\Entity\Person;

/**
 * Description of PersonManager
 *
 * @author Christophe
 */
class PersonManager extends BaseManager {

    use ConstantTrait;

    protected $tmdbPerson;

    public function __construct($em, $tmdbPerson, $security) {
        $this->tmdbPerson = $tmdbPerson;
        parent::__construct($em, $security);
    }

    public function isPersonExist($id) {
        $result = $this->getPerson($id);

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function getPerson($id) {
        return $this->getRepository()->findPerson($id);
    }

    public function getPersonName($id) {
        return $this->getRepository()->findPersonName($id);
    }

    public function getAllPerson() {
        return $this->getRepository()->findAllPerson();
    }

    public function addPerson($tmdbCredits) {

        $this->createPerson($this->getPersonToAdd($tmdbCredits));
    }

    public function getPersonToAdd($tmdbCredits) {
        $tmdbPeople = array();
        $tmdbCast = $this->getCastMembers($tmdbCredits);
        foreach ($tmdbCast as $people) {
            $id = $people->getId();
            $name = $people->getName();
            $tmdbPeople[$id] = $name;
        }

        $tmdbCrew = $this->getCrewMembers($tmdbCredits);
        foreach ($tmdbCrew as $people) {
            $id = $people->getId();
            $name = $people->getName();
            $tmdbPeople[$id] = $name;
        }

        $allPersonInDB = $this->getAllPerson();
        foreach ($allPersonInDB as $people) {
            $id = $people['id'];
            $name = $people['name'];
            $allPerson[$id] = $name;
        }
       // dump(array_diff_assoc($tmdbPeople, $allPerson));

        return array_diff_assoc($tmdbPeople, $allPerson);
    }

    public function createPerson($peopleToAdd) {
        // Define the size of record, the frequency for persisting the data and the current index of records
        $batchSize = $this->getBatchSizePersonManager();
        $i = 1;

        if (!empty($peopleToAdd)) {
            foreach ($peopleToAdd as $id => $name) {
                $tmdbPerson = $this->getTmdbPerson($id);      
                $person = new Person();
                $person->hydrate($tmdbPerson);
                $this->persist($person);

                // Each x import persisted we flush everything               
                if (($i % $batchSize) === 0) {
                    $this->flush();
                    $this->clear($person);
                }
                $i++;
            }
        }
    }
    
     public function getCastMembers($tmdbCredits) {
        return $tmdbCredits->getCast();
    }

    public function getCrewMembers($tmdbCredits) {
        return $tmdbCredits->getCrew();
    }

    public function updatePerson($id) {
        $tmdbPerson = $this->tmdbPerson->load($id);
        $person = $this->getPerson($id);
        // dump($person);
        $person->hydrate($tmdbPerson);
    }

    public function getTmdbPerson($id) {
        return $this->tmdbPerson->load($id, array('append_to_response' => 'images'));
    }

    public function getTmdbCredits($id, $language) {
        return $this->tmdbPerson->load($id, array('append_to_response' => 'movie_credits,images', 'language' => $language));
    }

    public function getRepository() {
        return $this->em->getRepository('bestopheVideoCollectionBundle:Person');
    }

}

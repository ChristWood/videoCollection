<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Entity\MovieCast;
//use bestophe\VideoCollectionBundle\Manager\BaseManager;
use bestophe\VideoCollectionBundle\Manager\PersonManager;

/**
 * Description of MovieCastManager
 *
 * @author Christophe
 */
class MovieCastManager extends PersonManager {

    public function isMovieCastExist($newMovie) {
        $result = $this->getAllMovieCast($newMovie);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function addMovieCast($tmdbCredits, $newMovie) {
        if (!$this->isMovieCastExist($newMovie)) {
            $tmdbCastMembers = $this->getCastMembers($tmdbCredits);
         //   dump($tmdbCastMembers);
            foreach ($tmdbCastMembers as $tmdbMember) {               
                $id = $tmdbMember->getId();
                $person = $this->getPerson($id);
               // dump($person);
                
                $movieCast = new MovieCast();
                $movieCast->hydrate($tmdbMember);
                $newMovie->addMovieCast($movieCast);
                $person->addMovieCast($movieCast);
                //$movieCast->setMovie($newMovie);
                //$movieCast->setPerson($person);
                $this->persist($movieCast);
            }
        }
        //$this->flush();
    }

    public function getAllMovieCast($movie) {
        return $movie->getMovieCast()->getValues();
    }

//    public function getRepository() {
//        return $this->em->getRepository('bestopheVideoCollectionBundle:MovieCast');
//    }
}

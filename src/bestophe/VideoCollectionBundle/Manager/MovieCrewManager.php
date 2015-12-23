<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Entity\MovieCrew;
use bestophe\VideoCollectionBundle\Manager\PersonManager;

/**
 * Description of MovieCrewManager
 *
 * @author Christophe
 */
class MovieCrewManager extends PersonManager {

    public function isMovieCrewExist($newMovie) {
        $result = $this->getAllMovieCrew($newMovie);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function addMovieCrew($tmdbCredits, $newMovie) {
        if (!$this->isMovieCrewExist($newMovie)) {
            $tmdbCrewMembers = $this->getCrewMembers($tmdbCredits);

            foreach ($tmdbCrewMembers as $tmdbMember) {

                if ($this->isPersonExist($tmdbMember->getId())) {
                    $person = $this->getPerson($tmdbMember->getId());
                    //  dump($person);
                    $movieCrew = new MovieCrew();
                    $movieCrew->hydrate($tmdbMember);

                    $this->persist($movieCrew);
                    $newMovie->addMovieCrew($movieCrew);
                    $person->addMovieCrew($movieCrew);
                }
            }
        }
    }

    public function getAllMovieCrew($movie) {
        return $movie->getMovieCrew()->getValues();
    }

}

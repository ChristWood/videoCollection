<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Manager\PersonManager;
use bestophe\VideoCollectionBundle\Manager\FunctionTrait;
use bestophe\VideoCollectionBundle\Manager\ConstantTrait;
use Tmdb\Model\Query\Discover\DiscoverMoviesQuery;

/**
 * Description of SearchManager
 *
 * @author Christophe
 * 
 */
class CreditsManager extends PersonManager {

    use FunctionTrait,
        ConstantTrait;

    protected $tmdbDiscover;

    public function __construct($em, $tmdbPerson, $tmdbDiscover, $security) {
        $this->tmdbDiscover = $tmdbDiscover;
        parent::__construct($em, $tmdbPerson, $security);
    }

    public function getPersonCredits($id) {
        $person = $this->getTmdbCredits($id, $this->getLanguage());
        $personCast = $person->getMovieCredits()->getCast()->toArray();
        $personCrew = $person->getMovieCredits()->getCrew()->toArray();
        $movieCredits = array_merge($personCast, $personCrew);
        
        foreach ($movieCredits as $movie) {

            $movieArray[] = array(
                'adult' => $movie->getAdult(),
                'character' => $movie->getCharacter(),
                'creditId' => $movie->getCreditId(),
                'id' => $movie->getId(),
                'originalTitle' => $movie->getOriginalTitle(),
                'posterPath' => $movie->getPosterPath(),
                'releaseDate' => $movie->getReleaseDate(),
                'title' => $movie->getTitle(),
                'posterImage' => $movie->getPosterImage(),
                'job' => $movie->getJob(),
                'department' => $movie->getDepartment()
            );
        }
        return $this->array_sort($movieArray, 'releaseDate', SORT_DESC);
    }

    public function getMajorMovies($number, $id, $sortById) {
        $knownFor = array();
        $sortBy = $this->getSortBy($sortById);
        $listMovies = $this->getTmdbDiscover($id, $sortBy);
        foreach ($listMovies as $movie) {
            $knownFor[] = array(
                'id' => $movie->getId(),
                'posterPath' => $movie->getPosterPath(),
                'releaseDate' => $movie->getReleaseDate(),
                'title' => $movie->getTitle(),
                'posterImage' => $movie->getPosterImage()
            );
        }
        return array_slice($knownFor, 0, $number);
    }

    public function getTmdbDiscover($id, $sortBy) {
        $query = new DiscoverMoviesQuery();
        $query
                ->page(1)
                ->language($this->getLanguage())
                ->withCast($id)
                ->voteAverageGte($this->getVoteAverage())
                ->sortBy($sortBy)
        ;

        return $this->tmdbDiscover->discoverMovies($query);
    }

    public function getNameForWiki($id) {
        $result = $this->getRepository()->findPersonName($id);
        return $this->removeSpace($result[0]['name']);
    }

    private function getSortBy($id) {

        switch ($id) {
            case 1:
                $sortBy = 'popularity.asc';
                break;
            case 2:
                $sortBy = 'popularity.desc';
                break;
            case 3:
                $sortBy = 'vote_average.asc';
                break;
            case 4:
                $sortBy = 'vote_average.desc';
                break;
            case 5:
                $sortBy = 'vote_count.asc';
                break;
            case 6:
                $sortBy = 'vote_count.desc';
                break;
        }
        return $sortBy;
    }

    function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }

}

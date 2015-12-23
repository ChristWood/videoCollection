<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Manager\TranslatableManager;
use bestophe\VideoCollectionBundle\Entity\Movie;

/**
 * Description of MovieManager
 *
 * @author Christophe
 */
class MovieManager extends TranslatableManager {

    protected $tmdbMovie;

    public function __construct($em, $class, $movieTmdb, $security) {

        $this->tmdbMovie = $movieTmdb;
        parent::__construct($em, $class, $security);
    }

    public function isMovieExist($id) {

        $result = $this->getMovie($id);

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function isMovieTranslationExist($movie, $language) {
        $movieLocale = $this->getMovieTranslations($movie);
        $result = false;
        foreach ($movieLocale as $key => $value) {
            if ($key == $language) {
                $result = true;
            }
        }
        return $result;
    }

    public function createMovie($tmdbMovie) {

        if (!$this->isMovieExist($tmdbMovie->getId())) {
            $newMovie = new Movie();
            $newMovie->hydrate($tmdbMovie);
            $this->persist($newMovie);
        } else {
            $newMovie = $this->getMovie($tmdbMovie->getId());
        }
        $this->translation($newMovie, $tmdbMovie);
        return $newMovie;
    }

    public function getMovie($id) {
        return $this->getRepository()->findMovie($id);
    }

    public function translation($newMovie, $tmdbMovie) {
        $languages = $this->getLanguagesAvailable();
        foreach ($languages as $language) {
            if (!$this->isMovieTranslationExist($newMovie, $language)) {
                $movieLocale = $this->getTmdbMovie($tmdbMovie->getId(), $language);
                $items = ['title', 'overview', 'tagline'];
                foreach ($items as $item) {
                    $translation = $this->translateItem($movieLocale, $item);
                    $this->getRepositoryGedmo()->translate($newMovie, $item, $language, $translation);
                }
            }
        }
    }

    public function getMovieTranslations($movie) {
        return $this->getRepositoryGedmo()->findTranslations($movie);
    }

    public function translateItem($movieLocale, $item) {

        $method = 'get' . ucfirst($item) . 'Locale';

        if (method_exists($this, $method)) {
            return $this->$method($movieLocale);
        }
    }

    public function getTitleLocale($movieLocale) {
        return $movieLocale->getTitle();
    }

    public function getOverviewLocale($movieLocale) {
        return $movieLocale->getOverview();
    }

    public function getTaglineLocale($movieLocale) {
        return $movieLocale->getTagline();
    }

    public function getMovieTitleInLocale($id, $locale) {
        return $this->getRepository()->findMovieTitleInLocale($id, $locale);
    }


    public function getAllMovieId() {
        return $this->getRepository()->findAllMovieId();
    }

    public function getAllMovies() {
        return $this->getRepository()->findAllMovies();
    }

    public function getTmdbMovie($id, $language) {
        return $this->tmdbMovie->load($id, array('language' => $language));
    }

    public function getTmdbCreditsMovie($id) {
        return $this->tmdbMovie->getCredits($id);
    }

}

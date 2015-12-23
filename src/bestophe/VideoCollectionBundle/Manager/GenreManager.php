<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Manager\TranslatableManager;
use bestophe\VideoCollectionBundle\Entity\Genre;
use bestophe\VideoCollectionBundle\Manager\ConstantTrait;

/**
 * Description of GenreManager
 *
 * @author Christophe
 */
class GenreManager extends TranslatableManager {

    use ConstantTrait;

    protected $genreTmdb;

    public function __construct($em, $class, $genreTmdb, $security) {
        $this->genreTmdb = $genreTmdb;
        parent::__construct($em, $class, $security);
    }

    public function isGenreExist($id) {

        $result = $this->getGenre($id);

        if ($result !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function isGenreTranslationExist($genre, $language) {
        $genreLocale = $this->getGenreTranslations($genre);
        $result = false;
        foreach ($genreLocale as $key => $value) {

            if ($key == $language) {
                $result = true;
            }
        }
        return $result;
    }

    public function addGenre($movieGenre) {
        $genre = new Genre();
        $genre->hydrate($movieGenre);
        $this->persist($genre);
        return $genre;
    }

    public function addMovieGenre($tmdbMovie, $newMovie) {
        $tmdbMovieGenres = $tmdbMovie->getGenres();

        foreach ($tmdbMovieGenres as $movieGenre) {
            if (!$this->isGenreExist($movieGenre->getId())) {
                $genre = $this->addGenre($movieGenre);
            } else {
                $genre = $this->getGenre($movieGenre->getId());
            }
            if (!empty($genre)) {
                $newMovie->addGenre($genre);
                $this->translation($genre, $movieGenre);
            }
        }
    }

    public function translation($genre, $movieGenre) {
        $language = $this->getLanguage();
        if (!$this->isGenreTranslationExist($genre, $language)) {
            $tmdbGenreListLocale = $this->getTmdbGenreList($language);
            $translation = $this->translatedGenre($tmdbGenreListLocale, $movieGenre->getId());
            if ($translation != null) {
                $this->getRepositoryGedmo()->translate($genre, 'name', $language, $translation);
            }
        }
    }

    public function translatedGenre($tmdbGenreListLocale, $id) {
        $result = null;

        foreach ($tmdbGenreListLocale as $tmdbGenre) {
            if ($tmdbGenre->getId() == $id) {
                $result = $this->getTmdbGenreName($tmdbGenre);
            }
        }
        return $result;
    }

    public function getGenresIdString() {
        $allGenresId = $this->getAllGenresId();

        foreach ($allGenresId as $key) {
            $genresId[] = $key['id'];
        }
        return implode(",", $genresId);
    }

    public function getTmdbGenreName($tmdbGenre) {
        return $tmdbGenre->getName();
    }

    public function getGenreTranslations($genre) {
        return $this->getRepositoryGedmo()->findTranslations($genre);
    }

    public function getGenre($id) {
        return $this->getRepository()->findGenre($id);
    }

    public function getTmdbGenreList($language) {
        return $this->genreTmdb->loadCollection(array('language' => $language));
    }

    public function getAllGenres() {
        return $this->getRepository()->findAllGenres();
    }

    public function getAllGenresId() {
        return $this->getRepository()->findAllGenresId();
    }

}

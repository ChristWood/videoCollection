<?php

namespace bestophe\VideoCollectionBundle\Manager;

/**
 * Description of ConstantTrait
 *
 * @author Christophe
 */
trait ConstantTrait {

    function getRecentlyMaxMovies() {
        return 7;
    }

    function getPosterViewMaxMovies() {
        return 6;
    }

    function getPosterViewMaxActors() {
        return 4;
    }

    function getCompactViewMaxMovies() {
        return 24;
    }

    function getBatchSizePersonManager() {
        return 30;
    }

    function getDefaultUserLanguage() {
        return 'fr';
    }

    function getMajorMaxMovies() { // used for known movies (personDetailController)
        return 8;
    }

    function getVoteAverage() { // used for known movies (personDetailController)
        return 6;
    }

    function getLanguagesAvailable() {
        return array('en' => 'en', 'fr' => 'fr');
    }

    function getPagerFantaMaxPerPage() {
        return 6;
    }

}

<?php

namespace bestophe\VideoCollectionBundle\Manager;

/**
 * Description of ParameterManager
 *
 * @author Christophe
 */
class ParameterManager {

    const RECENTLY_ADD_MAX_MOVIES = 4;
    const POSTER_VIEW_MAX_MOVIES = 6;
    const POSTER_VIEW_MAX_ACTORS = 4;
    const COMPACT_VIEW_MAX_MOVIES = 24;
    const BATCHSIZE_PERSON_MANAGER = 20;

    public static function getRecentlyMaxMovies() {
        return self::RECENTLY_ADD_MAX_MOVIES;
    }

    public static function getPosterViewMaxMovies() {
        return self::POSTER_VIEW_MAX_MOVIES;
    }

    public static function getPosterViewMaxActors() {
        return self::POSTER_VIEW_MAX_ACTORS;
    }

    public static function getCompactViewMaxMovies() {
        return self::COMPACT_VIEW_MAX_MOVIES;
    }

    public static function getBatchSizePersonManager() {
        return self::BATCHSIZE_PERSON_MANAGER;
    }

}

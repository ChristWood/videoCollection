<?php

namespace bestophe\VideoCollectionBundle\Manager;

use \Tmdb\Model\Search\SearchQuery\MovieSearchQuery;
use bestophe\VideoCollectionBundle\Manager\BaseManager;

/**
 * Description of SearchManager
 *
 * @author Christophe
 */
class SearchManager extends BaseManager {

    protected $searchTmdb;

    public function __construct($em, $searchTmdb, $security) {
        $this->searchTmdb = $searchTmdb;
        parent::__construct($em, $security);
    }

    public function getListSearchingMovie($searchTitle) {
        $query = new MovieSearchQuery();
        $query->language($this->getLanguage());
        return $this->searchTmdb->searchMovie($searchTitle, $query);
    }

}

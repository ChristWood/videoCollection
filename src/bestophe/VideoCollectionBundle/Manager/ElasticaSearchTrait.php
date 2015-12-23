<?php

namespace bestophe\VideoCollectionBundle\Manager;

/**
 * Description of ElasticaSearchTrait
 *
 * @author Christophe
 */
trait ElasticaSearchTrait {

    function getElasticaResults($querystring, $language) {
        switch ($language) {
            case 'en':
                $query = $this->getElasticaTitleEn($querystring);
                break;
            case 'fr':
                $query = $this->getElasticaTitleFr($querystring);
                break;
        }
        return $query;
    }

    function getElasticaTitleFr($querystring) {

        if ($querystring != null && $querystring != '') {
            $query = new \Elastica\Query\MultiMatch();
            $query->setFields(array('title_fr','name'));
            $query->setQuery($querystring);
            //  $query->setFieldFuzziness('title_fr', 0.7);
            //  $query->setFieldMinimumShouldMatch('title_fr', '80%');
        //
        } else {
            $query = new \Elastica\Query\MatchAll();
        }

        return $query;
    }

    function getElasticaTitleEn($querystring) {

        if ($querystring != null && $querystring != '') {
            $query = new \Elastica\Query\MultiMatch();
            $query->setFields(array('title_en','name'));
            //  $query->setFieldFuzziness('title_en', 0.7);
            //  $query->setFieldMinimumShouldMatch('title_en', '80%');
        //
        } else {
            $query = new \Elastica\Query\MatchAll();
        }

        return $query;
    }

}

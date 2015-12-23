<?php

namespace bestophe\VideoCollectionBundle\SearchRepostory;

use FOS\ElasticaBundle\Repository;

class MovieRepository extends Repository {
//
//    public function findTitleFr($querystring) {
//        if ($querystring != null && $querystring != '') {
//            $query = new \Elastica\Query\Match();
//            $query->setFieldQuery('title_fr', $querystring);
//            //  $query->setFieldFuzziness('title_fr', 0.7);
//            //  $query->setFieldMinimumShouldMatch('title_fr', '80%');
//        //
//        } else {
//            $query = new \Elastica\Query\MatchAll();
//        }
//
//        // return $this->findHybrid($query); if you also want the ES ResultSet
//        return $this->find($query);
//    }

}

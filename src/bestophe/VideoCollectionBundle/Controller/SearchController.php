<?php

namespace bestophe\VideoCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use bestophe\VideoCollectionBundle\Manager\ConstantTrait;
use bestophe\VideoCollectionBundle\Manager\ElasticaSearchTrait;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Description of AddNewMovieController
 *
 * @author Christophe
 */
class SearchController extends Controller {
    
    use ConstantTrait, ElasticaSearchTrait;

    public function indexAction(Request $request, $page) {

        $querystring = $request->query->get('query');
        $finder = $this->get('fos_elastica.finder.videocollection');

        $language = $this->get('bestophe_video_collection.movieManager')->getLanguage();
        $query= $this->getElasticaResults($querystring, $language);
        $results = $finder->find($query);
        $totalHits = count($results);
        $adapter = new ArrayAdapter($results);
        $pager = new Pagerfanta($adapter);
        $maxPerPage= $this->getPagerFantaMaxPerPage();
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($page);
       
        
//            if ($querystring != null && $querystring != '') {
//                $query = new \Elastica\Query\Match();
//                $query->setFieldQuery('title_fr', $querystring);
//                //  $query->setFieldFuzziness('title_fr', 0.7);
//                //  $query->setFieldMinimumShouldMatch('title_fr', '80%');
//            //
//        } else {
//                $query = new \Elastica\Query\MatchAll();
//            }
//
//            $results = $finder->find($query);
//
//            $totalHits = count($results);

        return $this->render('bestopheVideoCollectionBundle:MovieSection:SearchView.html.twig', array('listMovies' => $pager->getCurrentPageResults(), 'pager' => $pager, 'query' => $querystring, 'totalHits' => $totalHits));
    }

}

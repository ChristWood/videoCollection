<?php

namespace bestophe\VideoCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use bestophe\VideoCollectionBundle\Manager\ConstantTrait;

/**
 * Description of PersonDetailController
 *
 * @author Christophe
 */
class PersonDetailController extends Controller {
    
    use ConstantTrait;

    public function viewAction($id){

        $person = $this->get('bestophe_video_collection.personManager')->getPerson($id);        
        $movieCredits= $this->get('bestophe_video_collection.CreditsManager')->getPersonCredits($id);
        $nameForWiki = $this->get('bestophe_video_collection.CreditsManager')->getNameForWiki($id);
        $knownFor = $this->get('bestophe_video_collection.CreditsManager')->getMajorMovies($this->getMajorMaxMovies(), $id, $sortBy=6); 
        // Sorting choices :
        // 1: 'popularity.asc';
        // 2: 'popularity.desc';
        // 3: 'vote_average.asc';
        // 4: 'vote_average.desc';
        // 5: 'vote_count.asc';
        // 6: 'vote_count.desc';
        return $this->render('bestopheVideoCollectionBundle:MovieSection:PersonDetail.html.twig', array('person' => $person, 'movieCredits' => $movieCredits, 'nameForWiki' => $nameForWiki, 'knownFor' => $knownFor));
    }

}

<?php

namespace bestophe\VideoCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use bestophe\VideoCollectionBundle\Form\MovieUserType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of MovieDetailController
 *
 * @author Christophe
 */
class MovieDetailController extends Controller {

    public function viewAction(Request $request, $id) {

        $movieUserMovie = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserMovie($id);
        
        $form = $this->get('form.factory')->create(new MovieUserType, $movieUserMovie);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movieUserMovie);
            $em->flush();
        }

        return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieDetail.html.twig', array('movieUser' => $movieUserMovie, 'form' => $form->createView()));
    }

}

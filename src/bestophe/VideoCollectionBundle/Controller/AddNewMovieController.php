<?php

namespace bestophe\VideoCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AddNewMovieController
 *
 * @author Christophe
 */
class AddNewMovieController extends Controller {

    public function indexAction(Request $request) {
        $form = $this->createFormBuilder()
                ->add('title', 'text', array(
                    'attr' => array(
                        'placeholder' => 'addNewMovie.placeholder'),
                    'translation_domain' => 'menu'))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $searchTitle = $data['title'];
            return $this->resultsAction($searchTitle);
        }
        return $this->render('bestopheVideoCollectionBundle:AddNewMovie:MovieSearch.html.twig', array('MovieSearchForm' => $form->createView()));
    }

    public function resultsAction($searchTitle) {

        $results = $this->get('bestophe_video_collection.searchManager')->getListSearchingMovie($searchTitle);
        $totalPages = $results->getTotalPages();
        $totalResults = $results->getTotalResults();

        return $this->render('bestopheVideoCollectionBundle:AddNewMovie:SearchMovieResults.html.twig', array('movies' => $results,
                    'nbResults' => $totalResults, 'nbPages' => $totalPages, 'query' => $searchTitle));
    }

    public function saveAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            $data = $request->request->get('selectedMovie');
            foreach ($data as $id) {
                $this->createNewMovie($id);
            }
            //$request->getSession()->getFlashBag()->add('save', 'Annonce bien enregistrée.');
            return $this->redirect($this->generateUrl('bestophe_VideoCollection_home'));
        }
        return $this->redirect($this->generateUrl('bestophe_VideoCollection_addNewMovie'));
    }

    public function createNewMovie($id) {
        // get movie members (casting and crew team)
        $tmdbCredits = $this->get('bestophe_video_collection.movieManager')->getTmdbCreditsMovie($id);

        // get people facts and insertion in videoCollection database
        $this->get('bestophe_video_collection.personManager')->addPerson($tmdbCredits);
        $this->get('bestophe_video_collection.personManager')->flush();
        $this->get('bestophe_video_collection.personManager')->clear('bestophe\VideoCollectionBundle\Entity\Person');

        // get user language
        $language = $this->get('bestophe_video_collection.movieManager')->getLanguage();

        // request tmdb database and retrieve movie details
        $tmdbMovie = $this->get('bestophe_video_collection.movieManager')->getTmdbMovie($id, $language);

        // create movie record in videoCollection database
        $newMovie = $this->get('bestophe_video_collection.movieManager')->createMovie($tmdbMovie);
        $this->get('bestophe_video_collection.genreManager')->addMovieGenre($tmdbMovie, $newMovie);
        $this->get('bestophe_video_collection.movieCastManager')->addMovieCast($tmdbCredits, $newMovie);
        $this->get('bestophe_video_collection.movieCrewManager')->addMovieCrew($tmdbCredits, $newMovie);
        $this->get('bestophe_video_collection.movieUserManager')->addMovieUser($newMovie, $id);
        $this->get('bestophe_video_collection.movieManager')->flush();
        $this->get('bestophe_video_collection.movieManager')->clear();

        // $movie = $this->get('bestophe_video_collection.movieManager')->getMovie($id);
    }

}

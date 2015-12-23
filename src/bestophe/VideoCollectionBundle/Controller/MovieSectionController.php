<?php

namespace bestophe\VideoCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use bestophe\VideoCollectionBundle\Manager\ConstantTrait;
//use bestophe\VideoCollectionBundle\Form\ViewByGenreType;
//use bestophe\VideoCollectionBundle\Form\DisplayModeType;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Description of MovieSectionController
 *
 * @author Christophe
 */
class MovieSectionController extends Controller {

    use ConstantTrait;

    public function recentlyAddAction() {

        $maxMovies = $this->getRecentlyMaxMovies(); // Display n recently added movies
        $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getLastAddedMovies($maxMovies);

        return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/MovieLastAdded.html.twig', array('lastAdded' => $userListMovies));
    }

    public function AllMoviesAction($page) {

        $maxActors = $this->getPosterViewMaxActors();
        $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getAllMovieUserList();
        $adapter = new ArrayAdapter($userListMovies);
        $pager = new Pagerfanta($adapter);
        $maxPerPage = $this->getPagerFantaMaxPerPage();
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($page);
        $userListMovieCount = $pager->getNbResults();

        return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/MoviePosterViewFanta.html.twig', array(
                    'listMovies' => $pager->getCurrentPageResults(),
                    'pager' => $pager, 'nbActors' => $maxActors,
                    'totalMovies' => $userListMovieCount));
    }

    public function byGenreAction() {
        $genresIdString = $this->get('bestophe_video_collection.genreManager')->getGenresIdString();
        $id = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserFirstIdByGenre($genresIdString);
        return $this->paginationByGenreAction($id, 1);
    }

    public function paginationByGenreAction($id, $page) {
        $genresIdString = $this->get('bestophe_video_collection.genreManager')->getGenresIdString();
        $filterList = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserFilterByGenre($genresIdString);
        $userListMovieCount = count($this->get('bestophe_video_collection.movieUserManager')->getMovieUserListByGenre($id, $selectedFields = 1));

        $filterName = 'genre';
        $genreName = $this->get('bestophe_video_collection.genreManager')->getGenre($id)->getName();

        if (($userListMovieCount > 0)) {
            $nbActors = $this->getPosterViewMaxActors();
            $maxMovies = $this->getPosterViewMaxMovies();

            $pagination = array(
                'page' => $page,
                'route' => 'bestophe_VideoCollection_movieSectionPaginationByGenre',
                'pages_count' => ceil($userListMovieCount / $maxMovies),
                'route_params' => array('id' => $id)
            );
            $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserPageByGenre($page, $id, $maxMovies, $selectedFields = 1);

            return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/MoviePosterView.html.twig', array('filter' => $filterList, 'filterName' => $filterName, 'itemName' => $genreName, 'listMovies' => $userListMovies, 'nbActors' => $nbActors, 'pagination' => $pagination, 'totalMovies' => $userListMovieCount));

            // If the database is empty    
        } else {
            return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/MovieListEmptyView.html.twig', array('filter' => $filterList, 'filterName' => $filterName, 'itemName' => $genreName));
        }
    }

    public function byMediaAction() {

        $mediasIdString = $this->get('bestophe_video_collection.mediaManager')->getMediasIdString();
        $id = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserFirstIdByMedia($mediasIdString);
        return $this->paginationByMediaAction($id, 1);
    }

    public function paginationByMediaAction($id, $page) {
        $mediasIdString = $this->get('bestophe_video_collection.mediaManager')->getMediasIdString();
        $filterList = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserFilterByMedia($mediasIdString);
        $userListMovieCount = count($this->get('bestophe_video_collection.movieUserManager')->getMovieUserListByMedia($id, $selectedFields = 1));

        $filterName = 'media';
        $mediaName = $this->get('bestophe_video_collection.mediaManager')->getMedia($id)->getName();

        if (($userListMovieCount > 0)) {
            $nbActors = $this->getPosterViewMaxActors();
            $maxMovies = $this->getPosterViewMaxMovies();

            $pagination = array(
                'page' => $page,
                'route' => 'bestophe_VideoCollection_movieSectionPaginationByMedia',
                'pages_count' => ceil($userListMovieCount / $maxMovies),
                'route_params' => array('id' => $id)
            );

            $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserPageByMedia($page, $id, $maxMovies, $selectedFields = 1);

            return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/MoviePosterView.html.twig', array('filter' => $filterList, 'filterName' => $filterName, 'itemName' => $mediaName, 'listMovies' => $userListMovies, 'nbActors' => $nbActors, 'pagination' => $pagination, 'totalMovies' => $userListMovieCount));

            // If the database is empty    
        } else {
            return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/MovieListEmptyView.html.twig', array('filter' => $filterList, 'filterName' => $filterName, 'itemName' => $mediaName));
        }
    }

    public function alphaViewAction() {
//        $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserAlphaList($selectedFields = 2);
//        $userListMovieCount = count($userListMovies);
//
//        if (!empty($userListMovies)) {
//            return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/movieAlphaView.html.twig', array('listMovies' => $userListMovies, 'totalMovies' => $userListMovieCount));
//
//            // If the database is empty    
//        } else {
//            return $this->render('bestopheVideoCollectionBundle:homePage:CollectionEmpty.html.twig');
//        }
    }

    public function posterViewAction($page) {
//        $userListMovieCount = count($this->get('bestophe_video_collection.movieUserManager')->getMovieUserAlphaList($selectedFields = 1));
//
//        if (($userListMovieCount > 0)) {
//            $nbActors = $this->getPosterViewMaxActors();
//            $maxMovies = $this->getPosterViewMaxMovies();
//
//            $pagination = array(
//                'page' => $page,
//                'route' => 'bestophe_VideoCollection_movieSectionPosterView',
//                'pages_count' => ceil($userListMovieCount / $maxMovies),
//                'route_params' => array()
//            );
//
//            $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserAlphaPage($page, $maxMovies, $selectedFields = 1);
//
//            return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/moviePosterView.html.twig', array('listMovies' => $userListMovies, 'nbActors' => $nbActors, 'pagination' => $pagination, 'totalMovies' => $userListMovieCount));
//
//            // If the database is empty    
//        } else {
//            return $this->render('bestopheVideoCollectionBundle:homePage:CollectionEmpty.html.twig');
//        }
    }

    public function compactViewAction($page) {

//        $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserAlphaList($selectedFields = 3);
//        $userListMovieCount = count($userListMovies);
//
//        if (($userListMovieCount > 0)) {
//            $maxMovies = $this->getCompactViewMaxMovies();
//
//            $pagination = array(
//                'page' => $page,
//                'route' => 'bestophe_VideoCollection_movieSectionCompactView',
//                'pages_count' => ceil($userListMovieCount / $maxMovies),
//                'route_params' => array()
//            );
//
//            $userListMovies = $this->get('bestophe_video_collection.movieUserManager')->getMovieUserAlphaPage($page, $maxMovies, $selectedFields = 3);
//
//            return $this->render('bestopheVideoCollectionBundle:MovieSection:MovieList/movieCompactView.html.twig', array('listMovies' => $userListMovies, 'pagination' => $pagination, 'totalMovies' => $userListMovieCount));
//
//            // If the database is empty    
//        } else {
//            return $this->render('bestopheVideoCollectionBundle:homePage:CollectionEmpty.html.twig');
//        }
    }

    public function deleteMovieAction($id) {

        $movie = $this->get('bestophe_video_collection.movieManager')->getMovie($id);
        $this->get('bestophe_video_collection.movieUserManager')->removeMovieUser($movie);
        $this->get('bestophe_video_collection.movieUserManager')->flush();

        $url = $this->get('router')->generate('bestophe_VideoCollection_movieSectionAllMovies');
        return $this->redirect($url);
    }

}

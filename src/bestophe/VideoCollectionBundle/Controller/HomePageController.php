<?php

namespace bestophe\VideoCollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of HomepageController
 *
 * @author Christophe
 */
class HomePageController extends Controller {

    public function indexAction() {

        $user = $this->getUser();

        if ($user === null) {       // Redirect to Homepage for no-registered user
            return $this->render('bestopheVideoCollectionBundle:HomePage:WelcomeGuest.html.twig');
        } else {
            $userMovies = $this->get('bestophe_video_collection.MovieUserManager')->checkMovieUserList(); // Is there any movie in the user database ?

            if (($userMovies != null)) {
                // If user has movie(s), display the MovieSection page

                $url = $this->get('router')->generate('bestophe_VideoCollection_movieSectionRecentlyAdd');
                return $this->redirect($url);

                // If not, it's a new user with no movies    
            } else {
                return $this->render('bestopheVideoCollectionBundle:HomePage:CollectionEmpty.html.twig');
            }
        }
    }

}

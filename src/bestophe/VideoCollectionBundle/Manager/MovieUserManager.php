<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Entity\MovieUser;
use bestophe\VideoCollectionBundle\Manager\BaseManager;

/**
 * Description of MovieUserManager
 *
 * @author Christophe
 */
class MovieUserManager extends BaseManager {

    public function isMovieUserMovieExist($id) {

        $result = $this->getMovieUserMovie($id);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkMovieUserList() {
        return $this->getRepository()->checkMovieUserList($this->getUser());
    }

    public function addMovieUser($newMovie, $id) {
        $userId = $this->getUserId();
        if (!$this->isMovieUserMovieExist($id)) {
            $movieUser = new MovieUser();
            $newMovie->addMovieUser($movieUser);
            $movieUser->setUserId($userId);
            $this->persist($movieUser);
        }
    }

    public function removeMovieUser($movie) {
        $movieUser = $this->getMovieUserMovie($movie->getId());
        $movie->removeMovieUser($movieUser);
        $this->remove($movieUser);
    }

    public function getMovieUserMovie($id) {
        return $this->getRepository()->findMovieUserMovie($id, $this->getUser());
    }

//    public function getLastAddedMovies($n, $selectedFields) {
//        $fields = $this->getDataFields($selectedFields);
//        return $this->getRepository()->findRecentMovies($n, $this->getUserId(), $fields);
//    }

    public function getLastAddedMovies($n) {
        $locale = $this->getLanguage();
        return $this->getRepository()->findRecentMovies($n, $this->getUserId(), $locale);
    }

//    public function getMovieUserAlphaList($selectedFields) {
//        $fields = $this->getDataFields($selectedFields);
//        return $this->getRepository()->findMovieUserListAlphaOrder($this->getUser(), $fields);
//    }

//    public function getMovieUserAlphaPage($page, $maxPerPage, $selectedFields) {
//        $fields = $this->getDataFields($selectedFields);
//        //  $fields = array('m');
//        // $fields = array('m.id', 'm.title','m.releaseDate','m.overview','m.posterPath');
//        $result = $this->getRepository()->findMovieUserListPaginator($this->getUserId(), $fields, $page, $maxPerPage);
////        $r= $result->getQuery()->getArrayResult();
////        dump($r);
////        exit;
//        return $result;
//    }

    public function getAllMovieUserList() {
        $locale = $this->getLanguage();
        return $this->getRepository()->findAllMovieUserList($this->getUserId(), $locale);
    }

    public function getMovieUserPageByGenre($page, $genreId, $maxPerPage, $selectedFields) {
        $fields = $this->getDataFields($selectedFields);
        return $this->getRepository()->findMovieUserPageByGenre($this->getUser(), $fields, $genreId, $page, $maxPerPage);
    }

    public function getMovieUserListByGenre($genreId, $selectedFields) {
        $fields = $this->getDataFields($selectedFields);
        return $this->getRepository()->findMovieUserListByGenre($this->getUser(), $fields, $genreId);
    }

    public function getMovieUserFilterByGenre($genresId) {
        $locale = $this->getLanguage();
        return $this->getRepository()->findMovieUserFilterByGenre($this->getUser(), $genresId, $locale);
    }

    public function getMovieUserFirstIdByGenre($genresId) {
        $result = $this->getRepository()->findMovieUserFirstIdByGenre($this->getUser(), $genresId);
        return $result[0]['id'];
    }

    public function getMovieUserPageByMedia($page, $mediaId, $maxPerPage, $selectedFields) {
        $fields = $this->getDataFields($selectedFields);
        return $this->getRepository()->findMovieUserPageByMedia($this->getUser(), $fields, $mediaId, $page, $maxPerPage);
    }

    public function getMovieUserListByMedia($mediaId, $selectedFields) {
        $fields = $this->getDataFields($selectedFields);
        return $this->getRepository()->findMovieUserListByMedia($this->getUser(), $fields, $mediaId);
    }

    public function getMovieUserFilterByMedia($mediasId) {
        return $this->getRepository()->findMovieUserFilterByMedia($this->getUser(), $mediasId);
    }

    public function getMovieUserFirstIdByMedia($mediasId) {
        $result = $this->getRepository()->findMovieUserFirstIdByMedia($this->getUser(), $mediasId);
        return $result[0]['id'];
    }

    private function getDataFields($i) {

        switch ($i) {
            case 1:
                $fields = array('m');
                break;
            case 2:
                $fields = array('m.id', 'm.title');
                break;
            case 3:
                $fields = array('m.id', 'm.title', 'm.posterPath');
                break;
            case 4:
                $fields = array('m.id', 'm.title', 'm.posterPath', 'm.releaseDate');
                break;
        }
        return $fields;
    }

    public function getAllMovieUserByUser() {

        return $this->getRepository()->findBy(
                        array('userId' => $this->getUser())
        );
    }

    public function getAllMovieUser() {
        return $this->getRepository()->findAllMovieUser();
    }

    public function getRepository() {
        return $this->em->getRepository('bestopheVideoCollectionBundle:MovieUser');
    }

}

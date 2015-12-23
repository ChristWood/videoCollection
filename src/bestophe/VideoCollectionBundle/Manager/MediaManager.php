<?php

namespace bestophe\VideoCollectionBundle\Manager;

use bestophe\VideoCollectionBundle\Manager\BaseManager;

/**
 * Description of MediaManager
 *
 * @author Christophe
 */
class MediaManager extends BaseManager {

    public function __construct($em, $security) {
        
        parent::__construct($em, $security);
    }

    public function getMedia($id) {
        return $this->getRepository()->findMedia($id);
    }
    
    public function getAllMedias() {
        return $this->getRepository()->findAllMedias();
    }
    
    public function getAllMediasId() {
        return $this->getRepository()->findAllMediasId();
    }
    
    public function getMediasIdString() {
        $allMediasId = $this->getAllMediasId();

        foreach ($allMediasId as $key) {
            $mediasId[] = $key['id'];
        }
        return implode(",", $mediasId);
    }
    
     public function getRepository() {
        return $this->em->getRepository('bestopheVideoCollectionBundle:Media');
    }
}

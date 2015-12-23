<?php

namespace bestophe\VideoCollectionBundle\DoctrineListener;

use Doctrine\ORM\Event\OnFlushEventArgs;
use bestophe\VideoCollectionBundle\Entity\Cast;
use bestophe\VideoCollectionBundle\Entity\Crew;
use bestophe\VideoCollectionBundle\Entity\Person;

/**
 * Description of PersonAdd
 *
 * @author Christophe
 */
class PersonChange {

    private $tmdb;

    public function __construct($tmdb) {
        $this->tmdb = $tmdb;
    }

    public function onFlush(OnFlushEventArgs $eventArgs) {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $cmf = $em->getMetadataFactory();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {

            $meta = $cmf->getMetadataFor(get_class($entity));
            $this->updatePerson($em, $entity);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            
        }

        foreach ($uow->getScheduledCollectionDeletions() as $col) {
            
        }

        foreach ($uow->getScheduledCollectionUpdates() as $col) {
            
        }
    }

    public function updatePerson($em, $entity) {

        if ($entity instanceof Cast || $entity instanceof Crew) {

            $id = $entity->getPersonId();
            $people = $this->tmdb->load($id);
            if (!$this->existPerson($id,$em)) {
                $person = new Person();
                $person->setId($people->getId())
                        ->setAdult($people->getAdult())
                        ->setAka($people->getAlsoKnownAs())
                        ->setBiography($people->getBiography())
                        ->setBirthday($people->getBirthday())
                        ->setDeathday($people->getDeathday())
                        ->setHomepage($people->getHomepage())
                        ->setName($people->getName())
                        ->setPlaceOfBirth($people->getPlaceOfBirth())
                        ->setProfilePath($people->getProfilePath());

                $uow = $em->getUnitOfWork();
                $cmf = $em->getMetadataFactory();
                $meta = $cmf->getMetadataFor(get_class($person));

                $em->persist($person);

                $uow->computeChangeSet($meta, $person);
            }
        }
    }

    private function existPerson($id, $em) {
        
        $person = $em->getRepository('bestopheVideoCollectionBundle:Person')->find($id);

        if ($person === null) {
            return false;
        } else {
            return true;
        }
    }

}

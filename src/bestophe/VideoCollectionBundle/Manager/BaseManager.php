<?php

namespace bestophe\VideoCollectionBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Description of BaseManager
 *
 * @author Christophe
 */
abstract class BaseManager {

    use ConstantTrait;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $security;

    /**
     * Constructor
     *
     * @param EntityManager $em    Entity manager
     */
    public function __construct(EntityManager $em, TokenStorage $security) {
        $this->em = $em;
        $this->security = $security;
    }

    public function getUser() {
        return $this->security->getToken()->getUser();
    }

    public function getUserId() {
        return $this->getUser()->getId();
    }

    public function getToken() {
        return $this->security->getToken();
    }

    public function getLanguage() {
        $language = $this->getUser()->getLanguage();
        if (empty($language)) {
            $language = $this->getDefaultUserLanguage();
        }
        return $language;
    }

    public function getEm() {

        return $this->em;
    }

    public function persist($entity) {
        $this->em->persist($entity);
    }

    public function merge($entity) {
        $this->em->merge($entity);
    }

    public function flush() {
        $this->em->flush();
    }

    public function clear() {
        $this->em->clear();
    }

    public function remove($entity) {
        $this->em->remove($entity);
    }

}

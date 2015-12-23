<?php

namespace bestophe\VideoCollectionBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use bestophe\VideoCollectionBundle\Entity\Translation\TranslatableRepository;
use bestophe\VideoCollectionBundle\Manager\BaseManager;

/**
 * Description of TranslatableManager
 *
 * @author Christophe
 */

/**
 * Translatable entity manager
 */
class TranslatableManager extends BaseManager {

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string Class name
     */
    protected $class;
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    //protected $em;

    public function __construct(EntityManager $em, $class, $security) {
        $this->class = $class;
       // $this->em = $em;
        $this->repository = $em->getRepository($this->class);
        parent::__construct($em, $security);
    }

    /**
     * Sets the repository request default locale
     *
     * @param ContainerInterface|null $container
     * 
     * @throws \InvalidArgumentException if repository is not an instance of TranslatableRepository
     */
    public function setRepositoryLocale($container) {
        if (null !== $container) {
            if (!$this->repository instanceof TranslatableRepository) {
                throw new \InvalidArgumentException('A TranslatableManager needs to be linked with a TranslatableRepository to sets default locale.');
            }

            if ($container->isScopeActive('request')) {
                $locale = $container->get('request')->getLocale();
                $this->repository->setDefaultLocale($locale);
            }
        }
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositoryGedmo() {
        return $this->em->getRepository('Gedmo\Translatable\Entity\Translation');
    }

}

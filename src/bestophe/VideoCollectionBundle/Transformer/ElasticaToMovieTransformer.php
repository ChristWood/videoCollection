<?php

namespace bestophe\VideoCollectionBundle\Transformer;

use FOS\ElasticaBundle\Doctrine\AbstractElasticaToModelTransformer;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\Common\Persistence\ManagerRegistry;

class ElasticaToMovieTransformer extends AbstractElasticaToModelTransformer {
    
        /**
     * Manager registry.
     *
     * @var ManagerRegistry
     */
    protected $registry = null;
    /**
     * Class of the model to map to the elastica documents.
     *
     * @var string
     */
    protected $objectClass = null;
    /**
     * Optional parameters.
     *
     * @var array
     */
    protected $options = array(
        'hydrate'        => true,
        'identifier'     => 'id',
        'ignore_missing' => false,
        'query_builder_method' => 'createQueryBuilder',
    );
    
    private $container;
    
    /**
     * Instantiates a new Mapper.
     *
     * @param ManagerRegistry $registry
     * @param string $objectClass
     * @param array  $options
     */
    public function __construct(ManagerRegistry $registry, Container $container, $objectClass, array $options = array())
    {
        $this->registry    = $registry;
        $this->objectClass = $objectClass;
        $this->options     = array_merge($this->options, $options);            
        $this->container = $container;
        parent::__construct($registry, $objectClass, $options);
    }   
    
    /**
     * Fetch objects for theses identifier values
     *
     * @param array $identifierValues ids values
     * @param Boolean $hydrate whether or not to hydrate the objects, false returns arrays
     * @return array of objects or arrays
     */
    protected function findByIdentifiers(array $identifierValues, $hydrate) {
        if (empty($identifierValues)) {
            return array();
        }
      
        $userId= $this->container->get('bestophe_video_collection.movieManager')->getUserId();
        
        $hydrationMode = $hydrate ? Query::HYDRATE_OBJECT : Query::HYDRATE_ARRAY ;
        $this->options['ignore_missing'] = true;
        
        $qb = $this->registry
                ->getManagerForClass('bestopheVideoCollectionBundle:Movie')
                ->getRepository('bestopheVideoCollectionBundle:Movie')
                ->createQueryBuilder('m')
                ->join('bestophe\VideoCollectionBundle\Entity\MovieUser', 'u', 'WITH', 'm.id= u.movie')
              //  ->select (array('m.id','m.title', 'm.releaseDate', 'm.posterPath'));
                ->select('m');

        /* @var $qb \Doctrine\ORM\QueryBuilder */
        $qb->where($qb->expr()->in('m.' . $this->options['identifier'], ':values'))
                ->setParameter('values', $identifierValues);
        $qb->andwhere('u.userId= :userId')
                ->setParameter('userId', $userId);
        return $qb->getQuery()->setHydrationMode($hydrationMode)->execute();
    }

}

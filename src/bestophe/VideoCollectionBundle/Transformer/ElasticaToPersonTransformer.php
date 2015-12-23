<?php

namespace bestophe\VideoCollectionBundle\Transformer;

use FOS\ElasticaBundle\Doctrine\AbstractElasticaToModelTransformer;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;

class ElasticaToPersonTransformer extends AbstractElasticaToModelTransformer {

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
        'hydrate' => true,
        'identifier' => 'id',
        'ignore_missing' => false,
        'query_builder_method' => 'createQueryBuilder',
    );
    private $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Instantiates a new Mapper.
     *
     * @param ManagerRegistry $registry
     * @param string $objectClass
     * @param array  $options
     */
    public function __construct(ManagerRegistry $registry, Container $container, $objectClass, array $options = array()) {
        $this->registry = $registry;
        $this->objectClass = $objectClass;
        $this->options = array_merge($this->options, $options);
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

        $userId = $this->container->get('bestophe_video_collection.movieManager')->getUserId();

        $hydrationMode = $hydrate ? Query::HYDRATE_OBJECT : Query::HYDRATE_ARRAY;
        $this->options['ignore_missing'] = true;

        $qb = $this->registry
                ->getManagerForClass('bestopheVideoCollectionBundle:Person')
                ->getRepository('bestopheVideoCollectionBundle:Person')
                ->createQueryBuilder('p')
                ->join('bestophe\VideoCollectionBundle\Entity\MovieCast', 'a', 'WITH', 'p.id= a.person')
                //   ->join('bestophe\VideoCollectionBundle\Entity\MovieCrew', 'e', 'WITH', 'p.id= e.person')
                ->join('bestophe\VideoCollectionBundle\Entity\Movie', 'm', 'WITH', 'm.id= a.movie')
                //    ->join('bestophe\VideoCollectionBundle\Entity\Movie', 'o', 'WITH', 'o.id= e.movie')
                ->join('bestophe\VideoCollectionBundle\Entity\MovieUser', 'u', 'WITH', 'm.id= u.movie')
                // ->join('bestophe\VideoCollectionBundle\Entity\MovieUser', 's', 'WITH', 'o.id= s.movie')
                ->select('p');

        /* @var $qb \Doctrine\ORM\QueryBuilder */
        $qb->where($qb->expr()->in('p.' . $this->options['identifier'], ':values'))
                ->setParameter('values', $identifierValues);
        $qb->andwhere('u.userId= :userId')
                ->setParameter('userId', $userId);
        $results= $qb->getQuery()->setHydrationMode($hydrationMode)->execute();
        
        $qb1 = $this->registry
                ->getManagerForClass('bestopheVideoCollectionBundle:Person')
                ->getRepository('bestopheVideoCollectionBundle:Person')
                ->createQueryBuilder('p')
                ->join('bestophe\VideoCollectionBundle\Entity\MovieCrew', 'e', 'WITH', 'p.id= e.person')
                ->join('bestophe\VideoCollectionBundle\Entity\Movie', 'o', 'WITH', 'o.id= e.movie')
                ->join('bestophe\VideoCollectionBundle\Entity\MovieUser', 's', 'WITH', 'o.id= s.movie')
                ->select('p');

        /* @var $qb \Doctrine\ORM\QueryBuilder */
        $qb1->where($qb->expr()->in('p.' . $this->options['identifier'], ':values'))
                ->setParameter('values', $identifierValues);
        $qb1->andwhere('s.userId= :userId')
                ->setParameter('userId', $userId);
        
        $results1= $qb1->getQuery()->setHydrationMode($hydrationMode)->execute();
      //  dump($results);
     //   dump($results1);
        $merged_results= array_merge($results,$results1);
     //   dump($merged_results);
      //  exit;
        return $merged_results;
       // return $qb->getQuery()->setHydrationMode($hydrationMode)->execute();

   //     $em = $this->container->get('bestophe_video_collection.movieManager')->getEm();
        
//        $rsm = new ResultSetMapping;
//        $rsm->addEntityResult('bestophe\VideoCollectionBundle\Entity\Person', 'p');
//        $rsm->addFieldResult('p', 'id', 'id');
//        $rsm->addFieldResult('p', 'name', 'name');
//        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\MovieCast', 'a', 'p', 'movie_cast');
//        $rsm->addFieldResult('a', 'cast_id', 'id');
//        $rsm->addFieldResult('a', 'person_id', 'person_id');
////        $rsm->addFieldResult('a', 'movie', 'movie_id');
////        $rsm->addFieldResult('a', 'role', 'role');
////        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\MovieCrew', 'e', 'p', 'moviecrew');
////        $rsm->addFieldResult('e', 'person', 'person');
////        $rsm->addFieldResult('e', 'movie', 'movie');
////        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\Movie', 'm', 'p1', 'movie');
////        $rsm->addFieldResult('m', 'id', 'id');
////        $rsm->addFieldResult('m', 'title', 'title');
////        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\MovieUser', 'u', 'm', 'movieuser');
////        $rsm->addFieldResult('u', 'userid', 'userid');
//        $sql = 'SELECT p.id, p.name, a.id AS cast_id FROM person p ' .
//                'INNER JOIN moviecast a ON p.id= a.person_id';
//                
////        $rsm->addEntityResult('bestophe\VideoCollectionBundle\Entity\Moviecast', 'a');
////        $rsm->addFieldResult('a', 'id', 'id');
////        $rsm->addFieldResult('a', 'role', 'role');
////        $rsm->addFieldResult('a', 'person_id', 'person_id');
////       $sql = 'SELECT id, role, person_id FROM moviecast a ';
//        $query = $em->createNativeQuery($sql, $rsm);
//      //  $query->setParameter($userId, 'userid');
//
//
//        $results = $query->getResult();
//        dump($results);
//        exit;
//        return $results;

//        $rsm = new ResultSetMapping;
//        $rsm->addEntityResult('bestophe\VideoCollectionBundle\Entity\Person', 'p');
//        $rsm->addFieldResult('p', 'id', 'id');
//        $rsm->addFieldResult('p', 'name', 'name');
//        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\MovieCast', 'a', 'p', 'movie_cast');
//        $rsm->addFieldResult('a', 'person_id', 'person_id');
//        $rsm->addFieldResult('a', 'movie_id', 'movie_id');
//      //  $rsm->addFieldResult('a', 'role', 'role');
//        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\MovieCrew', 'e', 'p', 'movie_crew');
//        $rsm->addFieldResult('e', 'person_id', 'person_id');
//        $rsm->addFieldResult('e', 'movie_id', 'movie_id');
//        $rsm->addScalarResult('p1','p1');
//        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\Movie', 'm', 'p1', 'movie');
//        $rsm->addFieldResult('m', 'id', 'id');
//        $rsm->addFieldResult('m', 'title', 'title');
//        $rsm->addJoinedEntityResult('bestophe\VideoCollectionBundle\Entity\MovieUser', 'u', 'm', 'movie_user');
//        $rsm->addFieldResult('u', 'movie_id', 'movie_id');
//        $rsm->addFieldResult('u', 'userid', 'userid');
//        $sql = 'SELECT name FROM (SELECT p.id, p.name, a.movie_id FROM person p ' .
//                'INNER JOIN moviecast a ON p.id= a.person_id ' .
//                'UNION SELECT p.id, p.name, e.movie_id FROM person p ' .
//                'INNER JOIN moviecrew e ON p.id= e.person_id) AS p1 ' .
//                'INNER JOIN movie m ON m.id=p1.movie_id ' .
//                'INNER JOIN movieuser u ON m.id= u.movie_id WHERE userid=? ';
//        $query = $em->createNativeQuery($sql, $rsm);
//        $query->setParameter($userId, 'userid');


//        $results = $query->getResult();
//        dump($results);
//        exit;
//        return $results;

//        $rsm = new ResultSetMapping;
//        $rsm->addEntityResult('User', 'u');
//        $rsm->addFieldResult('u', 'id', 'id');
//        $rsm->addFieldResult('u', 'name', 'name');
//        $rsm->addJoinedEntityResult('Address', 'a', 'u', 'address');
//        $rsm->addFieldResult('a', 'address_id', 'id');
//        $rsm->addFieldResult('a', 'street', 'street');
//        $rsm->addFieldResult('a', 'city', 'city');
//
//        $sql = 'SELECT u.id, u.name, a.id AS address_id, a.street, a.city FROM users u ' .
//                'INNER JOIN address a ON u.address_id = a.id WHERE u.name = ?';
//        $query = $this->_em->createNativeQuery($sql, $rsm);
//        $query->setParameter(1, 'romanb');
//        $sql = 'select name, m.title from (select p.name, a.movie from person p ' .
//                'join moviecast a on p.id= a.person ' .
//                'UNION select p.name, e.movie_id from person p ' .
//                'join moviecrew e on p.id= e.person_id) AS p1 ' .
//                'join movie m on m.id=p1.movie_id ' .
//                'join movieuser u on m.id= u.movie_id where userid=? ';
//$sql = 'SELECT u.id, u.name, a.id AS address_id, a.street, a.city FROM users u ' .
//       'INNER JOIN address a ON u.address_id = a.id WHERE u.name = ?';
//$query = $this->_em->createNativeQuery($sql, $rsm);
//$query->setParameter(1, 'romanb');
//        $subQ1 = $this->registry
//                ->getManagerForClass('bestopheVideoCollectionBundle:Person')
//                ->getRepository('bestopheVideoCollectionBundle:Person')
//                ->createQueryBuilder('p')
//                ->select('p', 'a.movie')
//                ->join('bestophe\VideoCollectionBundle\Entity\MovieCast', 'a', 'WITH', 'p.id= a.person');
//
//        $subQ2 = $this->registry
//                ->getManagerForClass('bestopheVideoCollectionBundle:Person')
//                ->getRepository('bestopheVideoCollectionBundle:Person')
//                ->createQueryBuilder('p')
//                ->select('p', 'e.movie')
//                ->join('bestophe\VideoCollectionBundle\Entity\MovieCrew', 'e', 'WITH', 'p.id= e.person');
    }

//    select name, m.title from (select p.name, a.movie_id from person p
//join moviecast a on p.id= a.person_id
//UNION
//select p.name, e.movie_id from person p
//join moviecrew e on p.id= e.person_id) AS p1
//
//join movie m on m.id=p1.movie_id
//join movieuser u on m.id= u.movie_id
//where userid=4 
}

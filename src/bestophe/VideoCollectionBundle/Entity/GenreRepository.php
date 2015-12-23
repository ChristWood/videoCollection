<?php

namespace bestophe\VideoCollectionBundle\Entity;

use bestophe\VideoCollectionBundle\Entity\Translation\TranslatableRepository;

/**
 * GenreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GenreRepository extends TranslatableRepository {

    public function findGenre($id) {

        $qb = $this->createQueryBuilder('g');
        $qb
                ->where('g.id= :id')
                ->setParameter('id', $id)
        ;
        return $this->getOneOrNullResult($qb);
    }

    public function findAllGenres() {
        $qb = $this->createQueryBuilder('g');
        $qb->orderBy('g.name', 'ASC');

        return $this->getResult($qb);
    }

    public function findAllGenresId() {
        $qb = $this->createQueryBuilder('g');
        $qb->select('g.id');

        return $qb
                        ->getQuery()
                        ->getScalarResult();
    }
}

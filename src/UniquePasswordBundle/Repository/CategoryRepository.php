<?php

namespace UniquePasswordBundle\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * This method is responsible for fetching the number of stored elements of 
     * a given category name
     * 
     * @param string $name Name of the Category to search
     * @return int Number of results
     */
    public function findNumberOfPasswords($name)
    {
        return $this->getEntityManager()
            ->createQuery(
                    'SELECT count(p) FROM UniquePasswordBundle:Content p, UniquePasswordBundle:Category c WHERE c.id = p.category AND c.name = :name'
            )
            ->setParameter('name', $name)
            ->getResult();
    }

}

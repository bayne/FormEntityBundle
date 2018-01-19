<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Doctrine\ORM\EntityRepository;

/**
 * @codeCoverageIgnore
 */
class AbstractElementRepository extends EntityRepository
{
    /**
     * Returns all the elements for a given form
     *
     * @param FormEntity $formEntity
     *
     * @return AbstractElement[]
     */
    public function findAllElementsInForm(FormEntity $formEntity)
    {
        return $this
            ->createQueryBuilder('e')
            ->where('e.formEntity = :formEntity')
            ->setParameter('formEntity', $formEntity)
            ->getQuery()
            ->execute()
        ;
    }
}

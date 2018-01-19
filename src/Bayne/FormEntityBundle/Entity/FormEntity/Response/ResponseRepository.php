<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response;

use Bayne\FormEntityBundle\Entity\Evaluation;
use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Response;
use Doctrine\ORM\EntityRepository;

/**
 * @codeCoverageIgnore
 */
class ResponseRepository extends EntityRepository
{

    /**
     * Given a question, find the responses to it
     *
     * @param FormEntity $formEntity
     *
     * @return Response[]
     */
    public function findByFormEntity(FormEntity $formEntity)
    {
        return $this
            ->createQueryBuilder('r')
            ->where('r.formEntity= :formEntity')
            ->setParameter('formEntity', $formEntity)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @param FormEntity $formEntity
     *
     * @return string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCountForFormEntity(FormEntity $formEntity)
    {
        return $this
            ->createQueryBuilder('r')
            ->select('COUNT(DISTINCT r.id)')
            ->where('r.formEntity = :formEntity')
            ->getQuery()
            ->setParameter('formEntity', $formEntity)
            ->getSingleScalarResult()
        ;
    }
}

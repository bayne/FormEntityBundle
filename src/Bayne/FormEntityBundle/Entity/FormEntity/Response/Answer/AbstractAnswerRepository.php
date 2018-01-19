<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElement;
use Doctrine\ORM\EntityRepository;

/**
 * @codeCoverageIgnore
 */
class AbstractAnswerRepository extends EntityRepository
{
    public function getCountForElement(AbstractElement $formEntityElement)
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.question = :question')
            ->setParameter('question', $formEntityElement)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function findAnswersForQuestion(AbstractElement $abstractElement)
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.question = :question')
            ->setParameter('question', $abstractElement)
            ->getQuery()
            ->execute()
        ;
    }
}

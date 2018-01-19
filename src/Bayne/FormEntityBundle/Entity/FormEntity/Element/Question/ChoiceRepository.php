<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Question;

use Doctrine\ORM\EntityRepository;

/**
 * @codeCoverageIgnore
 */
class ChoiceRepository extends EntityRepository
{
    /**
     * Returns all choices for a given choicequestion
     *
     * @param ChoiceQuestion $choiceQuestion
     *
     * @return Choice[]
     */
    public function findAllChoicesInQuestion(ChoiceQuestion $choiceQuestion)
    {
        return $this
            ->createQueryBuilder('ca')
            ->where('ca.choiceQuestion = :choiceQuestion')
            ->setParameter('choiceQuestion', $choiceQuestion)
            ->getQuery()
            ->execute()
        ;
    }
}

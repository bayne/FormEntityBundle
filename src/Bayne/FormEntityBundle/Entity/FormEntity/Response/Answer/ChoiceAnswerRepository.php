<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\Choice;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceQuestion;
use Doctrine\ORM\EntityRepository;

/**
 * @codeCoverageIgnore
 */
class ChoiceAnswerRepository extends EntityRepository
{
    /**
     * @param Choice $choice
     *
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getAnswerCountForChoice(Choice $choice)
    {
        return $this
            ->createQueryBuilder('ca')
            ->select('count(ca.id)')
            ->where(':choice MEMBER OF ca.choices')
            ->setParameter('choice', $choice)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * @param ChoiceQuestion $choiceQuestion
     *
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getResponseCountForChoiceQuestion(ChoiceQuestion $choiceQuestion)
    {
        return $this
            ->createQueryBuilder('ca')
            ->select('count(distinct ca.response)')
            ->join('ca.choices', 'c')
            ->where('ca.question = :question')
            ->setParameter('question', $choiceQuestion)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * @param FormEntity $evaluationFormEntity
     *
     * @return array
     */
    public function getResponseCountsForFormEntity(FormEntity $evaluationFormEntity)
    {
        return $this
            ->createQueryBuilder('ca')
            ->select('q.id AS id, count(distinct ca.response) AS cnt')
            ->join('ca.choices', 'c')
            ->join('c.choiceQuestion', 'q')
            ->where('q.formEntity = :formEntity')
            ->groupBy('q.id')
            ->setParameter('formEntity', $evaluationFormEntity)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
     * @param FormEntity $evaluationFormEntity
     *
     * @return array
     */
    public function getAnswerCountsForFormEntity(FormEntity $evaluationFormEntity)
    {
        return $this
            ->createQueryBuilder('ca')
            ->select('c.id AS id, count(ca.id) AS cnt')
            ->join('ca.question', 'q')
            ->join('ca.choices', 'c')
            ->where('q.formEntity = :formEntity')
            ->groupBy('q.id, c.id')
            ->setParameter('formEntity', $evaluationFormEntity)
            ->getQuery()
            ->getArrayResult()
        ;
    }
}

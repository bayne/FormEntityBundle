<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\TextQuestion;
use Doctrine\ORM\EntityRepository;

/**
 * @codeCoverageIgnore
 */
class TextAnswerRepository extends EntityRepository
{
    public function findAnswersForTextQuestion(TextQuestion $textQuestion)
    {
        return array_column(
            $this
                ->createQueryBuilder('t')
                ->select('t.value')
                ->where('t.question = :question')
                ->andWhere("TRIM(t.value) != ''")
                ->getQuery()
                ->setParameter('question', $textQuestion)
                ->getArrayResult(),
            'value'
        );
    }
}

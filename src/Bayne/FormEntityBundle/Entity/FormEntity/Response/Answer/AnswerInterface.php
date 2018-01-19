<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\AbstractQuestionElement;

interface AnswerInterface
{
    /**
     * Returns the question that the answer is a response to
     *
     * @return AbstractQuestionElement
     */
    public function getQuestion();

    /**
     * A unique identifier for the element, used for editing and deleting
     *
     * @return int
     */
    public function getId();
}

<?php

namespace Bayne\FormEntityBundle\View\Common\FormEntity;

interface ElementInterface
{
    const MULTIPLE_SELECT_QUESTION = 'multiple_select';
    const MULTIPLE_CHOICE_QUESTION = 'choice_question';
    const TEXT_QUESTION = 'text_question';
    const TEXT_DECORATOR = 'text_decorator';
    const HORIZONTAL_LINE = 'horizontal_line';
    const HEADER_DECORATOR = 'header_decorator';

    /**
     * Returns the text for this element
     *
     * @return string
     */
    public function getText();

    /**
     * Returns the type of the element
     *
     * @return string
     */
    public function getType();

    /**
     * Returns true if the element is a question
     *
     * @return boolean
     */
    public function isQuestion();

    /**
     * Returns the position of the element
     *
     * @return int
     */
    public function getPosition();

}

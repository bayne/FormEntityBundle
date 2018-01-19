<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementInterface;

interface QuestionElementInterface extends ElementInterface
{
    /**
     * Returns the actual question for the element that is prompting the evaluator for a response
     *
     * @return string
     */
    public function getLabel();

    /**
     * The name of the element when it is being submitted on the form
     *
     * <input name={name} />
     *
     * @return string
     */
    public function getName();

    /**
     * The FormType that this element builds
     *
     * EX.
     * text, choice, email, etc
     *
     * @return string
     */
    public function getType();

    /**
     * The set of options that is used to build the FormType
     *
     * EX.
     * [
     *    'attr' => ['class' => 'text'],
     *    'choices' => [
     *                      ['A' => 'Choice A'],
     *                      ['B' => 'Choice B'],
     *                 ]
     * ]
     *
     * @return array
     */
    public function getOptions();
}

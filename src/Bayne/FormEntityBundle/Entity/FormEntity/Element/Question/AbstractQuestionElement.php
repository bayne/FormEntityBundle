<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElement;

abstract class AbstractQuestionElement extends AbstractElement implements QuestionElementInterface
{
    /**
     * The name of the element when it is being submitted on the form
     *
     * <input name={name} />
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getName()
    {
        return $this->getId();
    }
}

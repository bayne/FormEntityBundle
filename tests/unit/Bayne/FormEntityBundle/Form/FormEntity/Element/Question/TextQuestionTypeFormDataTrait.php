<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\TextQuestion;

trait TextQuestionTypeFormDataTrait
{
    private function getTextElementFromFormData(array $formData, FormEntity $formEntity = null)
    {
        return (new TextQuestion($formEntity))
            ->setLabel($formData['label'])
            ->setPosition($formData['position'])
        ;
    }
}

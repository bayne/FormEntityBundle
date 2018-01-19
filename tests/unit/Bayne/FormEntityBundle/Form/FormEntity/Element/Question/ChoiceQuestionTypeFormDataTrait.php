<?php


namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceQuestion;

trait ChoiceQuestionTypeFormDataTrait
{
    use ChoiceTypeFormDataTrait;

    private function getChoiceQuestionFromFormData(array $formData, FormEntity $formEntity = null)
    {
        $choiceQuestion = new ChoiceQuestion($formEntity);
        return $choiceQuestion
            ->setLabel($formData['label'])
            ->setMultiple($formData['multiple'])
            ->setChoices($this->getChoiceAnswersFromFormData($formData['choices'], $choiceQuestion))
            ->setPosition($formData['position'])
        ;
    }
}

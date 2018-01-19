<?php


namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\Choice;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceQuestion;
use Doctrine\Common\Collections\ArrayCollection;

trait ChoiceTypeFormDataTrait
{
    private function getChoiceAnswersFromFormData(array $formData, ChoiceQuestion $choiceQuestion)
    {
        $choiceAnswers = new ArrayCollection();

        foreach ($formData as $choice) {
            $choiceAnswer = new Choice($choiceQuestion);
            $choiceAnswer
                ->setLabel($choice['label'])
                ->setPosition($choice['position'])
                ->setWeight($choice['weight'])
            ;
            $choiceAnswers->add($choiceAnswer);
        }

        return $choiceAnswers;
    }
}

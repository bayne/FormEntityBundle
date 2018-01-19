<?php

namespace Bayne\FormEntityBundle\Form;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Doctrine\Common\Collections\ArrayCollection;

trait FormEntityTypeFormDataTrait
{
    private function getTemplateFromFormData($formData, $user)
    {
        $textElements = new ArrayCollection();
        $textDecorators = new ArrayCollection();
        $choiceQuestions = new ArrayCollection();
        $formEntity = (new FormEntity($user))
            ->setTitle($formData['title'])
        ;

        if (isset($formData['text_question_elements'])) {
            foreach ($formData['text_question_elements'] as $text_question) {
                $textElements->add($this->getTextElementFromFormData($text_question, $formEntity));
            }
        }

        if (isset($formData['choice_question_elements'])) {
            foreach ($formData['choice_question_elements'] as $choice_question) {
                $choiceQuestions->add($this->getChoiceQuestionFromFormData($choice_question, $formEntity));
            }
        }

        if (isset($formData['text_decorator_elements'])) {
            foreach ($formData['text_decorator_elements'] as $text_decorator) {
                $textDecorators->add($this->getTextDecoratorFromFormData($text_decorator, $formEntity));
            }
        }


        $formEntity->setTextQuestionElements($textElements);
        $formEntity->setChoiceQuestionElements($choiceQuestions);
        $formEntity->setTextDecoratorElements($textDecorators);

        return $formEntity;
    }
}

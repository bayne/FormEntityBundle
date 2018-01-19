<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\TextDecorator;

trait TextDecoratorTypeFormDataTrait
{
    private function getTextDecoratorFromFormData(array $formData, FormEntity $formEntity = null)
    {
        return (new TextDecorator($formEntity))
            ->setText($formData['text'])
            ->setPosition($formData['position'])
        ;
    }
}

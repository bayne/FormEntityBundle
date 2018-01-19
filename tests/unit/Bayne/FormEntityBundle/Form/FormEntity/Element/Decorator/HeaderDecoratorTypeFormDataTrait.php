<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\HeaderDecorator;

trait HeaderDecoratorTypeFormDataTrait
{
    private function getHeaderDecoratorFromFormData(array $formData, FormEntity $formEntity = null)
    {
        return (new HeaderDecorator($formEntity))
            ->setText($formData['text'])
            ->setPosition($formData['position'])
        ;
    }
}

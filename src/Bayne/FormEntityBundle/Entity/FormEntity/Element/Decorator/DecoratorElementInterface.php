<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementInterface;

interface DecoratorElementInterface extends ElementInterface
{
    /**
     * Returns the type of the decorator
     *
     * @return string
     */
    public function getDecoratorType();
}

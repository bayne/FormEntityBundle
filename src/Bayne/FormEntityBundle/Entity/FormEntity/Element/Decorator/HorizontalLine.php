<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElement;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class HorizontalLine extends AbstractElement implements DecoratorElementInterface
{
    /**
     * Returns the type of the decorator
     *
     * @return string
     */
    public function getDecoratorType()
    {
        return 'horizontalLine';
    }

    /**
     * @return bool
     */
    public function isHorizontalLine() {
        return true;
    }

    /**
     * Returns true if the provided element is a duplicate of this one
     *
     * @codeCoverageIgnore
     *
     * @param ElementInterface $other
     *
     * @return bool
     */
    public function isDuplicate(ElementInterface $other)
    {
        return
            $other instanceof HorizontalLine &&
            $this->getDecoratorType() === $other->getDecoratorType()
            ;
    }
}

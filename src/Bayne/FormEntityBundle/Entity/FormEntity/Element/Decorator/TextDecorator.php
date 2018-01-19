<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElement;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class TextDecorator extends AbstractElement implements DecoratorElementInterface
{
    /**
     * @codeCoverageIgnore
     *
     * @var string
     *
     * @Assert\Length(max=AbstractElement::MAX_TEXT_LENGTH)
     *
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $text
     *
     * @return TextDecorator
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Returns the type of the decorator
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getDecoratorType()
    {
        return 'text';
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
            $other instanceof TextDecorator &&
            $this->getDecoratorType() === $other->getDecoratorType() &&
            $this->getText() === $other->getText()
        ;
    }
}

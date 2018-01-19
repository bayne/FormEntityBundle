<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementInterface;
use Bayne\FormEntityBundle\Form\FormEntity\Response\TextAnswerType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An element that prompts the user with a label and accepts user text input
 *
 * @ORM\Entity()
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class TextQuestion extends AbstractQuestionElement
{
    /**
     * The label that prompts the user for this text element
     *
     * @var string
     *
     * @Assert\Length(max=TextQuestion::MAX_TEXT_LENGTH)
     *
     * @ORM\Column(type="text")
     */
    private $label;

    /**
     * The max length of the field
     *
     * @var int
     *
     * @Assert\Range(
     *     min="1",
     *     max=TextQuestion::MAX_TEXT_LENGTH,
     *     minMessage="The length of the field is too small",
     *     maxMessage="The length of the field is too long"
     * )
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $label
     *
     * @return TextQuestion
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * The SubmissionType that this element builds
     *
     * EX.
     * text, choice, email, etc
     *
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getType()
    {
        return TextAnswerType::class;
    }

    /**
     * The set of options that is used to build the SubmissionType
     *
     * EX.
     * [
     *    'attr' => ['class' => 'text'],
     *    'choices' => [
     *                      ['A' => 'Choice A'],
     *                      ['B' => 'Choice B'],
     *                 ]
     * ]
     *
     * @codeCoverageIgnore
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            'label' => $this->label,
            'question' => $this,
            'required' => false,
            'label_attr' => [
                'data-markdown' => true
            ]
        ];
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param int $size
     *
     * @return TextQuestion
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
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
            $other instanceof TextQuestion &&
            $this->getLabel() === $other->getLabel() &&
            $this->getSize() === $other->getSize()
        ;
    }
}

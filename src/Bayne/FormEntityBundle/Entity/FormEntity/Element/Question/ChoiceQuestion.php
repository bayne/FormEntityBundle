<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementInterface;
use Bayne\FormEntityBundle\Form\FormEntity\Response\ChoiceAnswerType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class ChoiceQuestion extends AbstractQuestionElement implements QuestionElementInterface
{
    /**
     * The label that prompts the user for this choice element
     *
     * @var string
     *
     * @Assert\Length(max=ChoiceQuestion::MAX_TEXT_LENGTH)
     *
     * @ORM\Column(type="text")
     */
    private $label;

    /**
     * @var Choice[]
     *
     * @Assert\Count(min=0)
     *
     * @ORM\OneToMany(
     *     cascade={"all"},
     *     targetEntity="Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\Choice",
     *     fetch="EAGER",
     *     mappedBy="choiceQuestion"
     * )
     */
    private $choices;

    /**
     * Flag to indicate if this choice field can have multiple possible answers selected
     *
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $multiple = false;

    public function __construct(FormEntity $formEntity = null)
    {
        parent::__construct($formEntity);
        $this->choices = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return ChoiceQuestion
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Choice[]|ArrayCollection
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param Choice[]|ArrayCollection $choices
     *
     * @return ChoiceQuestion
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @param boolean $multiple
     *
     * @return ChoiceQuestion
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * The SubmissionType that this element builds
     *
     * EX.
     * text, choice, email, etc
     *
     * @return string
     */
    public function getType()
    {
        return ChoiceAnswerType::class;
    }

    /**
     * The set of options that is used to build the SubmissionType
     *
     * EX.
     * [
     *    'attr' => ['class' => 'text'],
     *    'choices' => [
     *      ['A' => 'Choice A'],
     *      ['B' => 'Choice B'],
     *    ]
     * ]
     *
     * @codeCoverageIgnore
     *
     * @return array
     */
    public function getOptions()
    {
        $choices = $this->choices->toArray();
        usort($choices, function (Choice $a, Choice $b) {
            return $a->getPosition() - $b->getPosition();
        });

        return [
            'label' => $this->label,
            'label_attr' => [
                'data-markdown' => true
            ],
            'multiple' => $this->multiple,
            'choices' => $choices,
            'choices_as_values' => true,
            'choice_value' => 'position',
            'choice_label' => 'label',
            'expanded' => true,
            'question' => $this,
            'required' => false
        ];
    }

    /**
     * Does a deep-copy of the answer choices
     */
    public function __clone()
    {
        $clonedChoices = new ArrayCollection();
        foreach ($this->choices as $choice) {
            $clonedChoice = clone $choice;
            $clonedChoice->setChoiceQuestion($this);
            $clonedChoices->add($clonedChoice);
        }
        $this->choices = $clonedChoices;

        parent::__clone();
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
            $other instanceof ChoiceQuestion &&
            $this->isMultiple() == $other->isMultiple() &&
            $this->getLabel() == $other->getLabel() &&
            $this->choicesAreDuplicates($other)
        ;
    }

    /**
     * Returns true if the ChoiceQuestion has the same choices
     * 
     * @codeCoverageIgnore
     *
     * @param ChoiceQuestion $other
     *
     * @return bool
     */
    private function choicesAreDuplicates(ChoiceQuestion $other)
    {
        /** @var Choice[] $choices */
        $choices = array_values($this->getChoices()->toArray());
        /** @var Choice[] $otherChoices */
        $otherChoices = array_values($other->getChoices()->toArray());

        if (count($choices) !== count($otherChoices)) {
            return false;
        }

        foreach ($otherChoices as $i => $otherChoice) {
            if (false === $choices[$i]->isDuplicate($otherChoice)) {
                return false;
            }
        }

        return true;
    }
}

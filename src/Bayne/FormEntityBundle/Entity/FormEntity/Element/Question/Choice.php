<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElement;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceRepository")
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class Choice
{
    /**
     * Arbitrarily high max text length, decided to re-use question element's max text length since it is also
     * arbitrarily high.
     */
    const MAX_TEXT_LENGTH = AbstractElement::MAX_TEXT_LENGTH;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * The text associated to this choice answer
     *
     * @var string
     *
     * @Assert\Length(max=ChoiceQuestion::MAX_TEXT_LENGTH)
     *
     * @ORM\Column(type="text")
     */
    private $label;

    /**
     * A floating point value that represents the weight of the choice answer
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight = null;

    /**
     * The position of the element on the form
     *
     * @var int
     *
     * @Assert\Range(min="0", minMessage="Position of an element must be greater than 0")
     * @Assert\NotNull()
     *
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @var ChoiceQuestion
     *
     * @ORM\ManyToOne(
     *     targetEntity="Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceQuestion",
     *     inversedBy="choices",
     *     fetch="EAGER"
     * )
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $choiceQuestion;

    public function __construct(ChoiceQuestion $choiceQuestion = null)
    {
        $this->choiceQuestion = $choiceQuestion;
        if ($choiceQuestion !== null && !$choiceQuestion->getChoices()->contains($choiceQuestion)) {
            $choiceQuestion->getChoices()->add($this);
        }
    }

    /**
     * @codeCoverageIgnore
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return Choice
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     *
     * @return Choice
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return Choice
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param ChoiceQuestion $choiceQuestion
     *
     * @return Choice
     */
    public function setChoiceQuestion($choiceQuestion)
    {
        $this->choiceQuestion = $choiceQuestion;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return ChoiceQuestion
     */
    public function getChoiceQuestion()
    {
        return $this->choiceQuestion;
    }

    /**
     * Set the ID to null to let Doctrine know that this is a new entity
     */
    public function __clone()
    {
        $this->id = null;
    }

    /**
     * Returns true if the choice is a duplicate of another give choice
     * 
     * @codeCoverageIgnore
     *
     * @param Choice $choice
     *
     * @return bool
     */
    public function isDuplicate(Choice $choice)
    {
        return
            $this->getLabel() === $choice->getLabel() &&
            $this->getPosition() === $choice->getPosition() &&
            $this->getWeight() === $choice->getWeight()
        ;
    }
}

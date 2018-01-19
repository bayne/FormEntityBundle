<?php

namespace Bayne\FormEntityBundle\Entity;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\DecoratorElementInterface;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\HorizontalLine;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\HeaderDecorator;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\TextDecorator;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementCollectionTrait;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\ElementInterface;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\AbstractQuestionElement;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceQuestion;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\QuestionElementInterface;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\TextQuestion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents the form that was created by a user
 *
 * @ORM\Entity(repositoryClass="Bayne\FormEntityBundle\Entity\FormEntity\FormEntityRepository")
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class FormEntity
{
    const MAX_TITLE_LENGTH = 100;
    use ElementCollectionTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The user that created this form
     *
     * @var UserInterface
     *
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(targetEntity="Bayne\FormEntityBundle\Entity\UserInterface")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdByUser;

    /**
     * The title the user provided for the form
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=FormEntity::MAX_TITLE_LENGTH)
     *
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * All the elements that make up the form
     *
     * @var ArrayCollection
     *
     * @Assert\Valid
     *
     * @ORM\OneToMany(
     *     mappedBy="formEntity",
     *     targetEntity="Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElement",
     *     cascade={"all"}
     * )
     */
    private $elements;

    public function __construct(
        UserInterface $creator
    ) {
        $this->elements = new ArrayCollection();
        $this->createdByUser = $creator;
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
     * @codeCoverageIgnore
     *
     * @return UserInterface
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns the elements in the order of their position
     *
     * @return ArrayCollection
     */
    public function getElements()
    {
        $elements = $this->elements->toArray();
        usort($elements, function (ElementInterface $a, ElementInterface $b) {
            return $a->getPosition() - $b->getPosition();
        });

        $this->elements = new ArrayCollection($elements);

        return $this->elements;
    }

    /**
     * Returns elements in the collection that accept user input
     *
     * @return ArrayCollection|AbstractQuestionElement[]
     */
    public function getQuestionElements()
    {
        return $this->getElements()->filter(function ($element) {
            return $element instanceof QuestionElementInterface;
        });
    }

    /**
     * Returns elements in the collection that are only for decorating the form
     *
     * @return ArrayCollection|DecoratorElementInterface[]
     */
    public function getDecoratorElements()
    {
        return $this->getElements()->filter(function ($element) {
            return $element instanceof DecoratorElementInterface;
        });
    }

    /**
     * @param Collection $elements
     *
     * @return FormEntity
     */
    public function setElements(Collection $elements)
    {
        $this->elements = $elements;

        foreach ($this->elements as $element) {
            $element->setFormEntity($this);
        }

        return $this;
    }

    /**
     * @param ElementInterface $element
     *
     * @return FormEntity
     */
    public function addElement(ElementInterface $element)
    {
        $this->elements->add($element);

        return $this;
    }

    /**
     * Returns the TextQuestion for the given form
     *
     * @return ArrayCollection|Collection
     */
    public function getTextQuestionElements()
    {
        return $this->getElementsOfType($this->elements, TextQuestion::class);
    }

    /**
     * Sets the TextQuestions for the given form
     *
     * @param Collection $textElements
     *
     * @return FormEntity
     */
    public function setTextQuestionElements(Collection $textElements)
    {
        return $this->setElements(
            $this->replaceElementsOfType($this->elements, $textElements, TextQuestion::class)
        );
    }

    /**
     * Returns the ChoiceQuestions for the given form
     *
     * @return ArrayCollection|Collection
     */
    public function getChoiceQuestionElements()
    {
        return $this->getElementsOfType($this->elements, ChoiceQuestion::class);
    }

    /**
     * Sets the ChoiceQuestions for the given form
     *
     * @param Collection $choiceQuestions
     *
     * @return FormEntity
     */
    public function setChoiceQuestionElements(Collection $choiceQuestions)
    {
        return $this->setElements(
            $this->replaceElementsOfType($this->elements, $choiceQuestions, ChoiceQuestion::class)
        );
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getTextDecoratorElements()
    {
        return $this->getElementsOfType($this->elements, TextDecorator::class);
    }

    /**
     * @param Collection $textDecorators
     *
     * @return FormEntity
     */
    public function setTextDecoratorElements(Collection $textDecorators)
    {
        return $this->setElements(
            $this->replaceElementsOfType($this->elements, $textDecorators, TextDecorator::class)
        );
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getHorizontalLineElements()
    {
        return $this->getElementsOfType($this->elements, HorizontalLine::class);
    }

    /**
     * @param Collection $horizontalLines
     *
     * @return FormEntity
     */
    public function setHorizontalLineElements(Collection $horizontalLines)
    {
        return $this->setElements(
            $this->replaceElementsOfType($this->elements, $horizontalLines, HorizontalLine::class)
        );
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getHeaderDecoratorElements()
    {
        return $this->getElementsOfType($this->elements, HeaderDecorator::class);
    }

    /**
     * @param Collection $headerDecorators
     *
     * @return FormEntity
     */
    public function setHeaderDecoratorElements(Collection $headerDecorators)
    {
        return $this->setElements(
            $this->replaceElementsOfType($this->elements, $headerDecorators, HeaderDecorator::class)
        );
    }

    /**
     * Copies all the child fields of this object and sets the id to null to mark as a new entity in Doctrine
     */
    public function deepCopy()
    {
        $clonedElements = new ArrayCollection();
        foreach ($this->elements as $element) {
            $clonedElement = clone $element;
            $clonedElement->setFormEntity($this);
            $clonedElements->add($clonedElement);
        }
        $this->elements = $clonedElements;
        $this->id = null;
    }

    public function __clone()
    {
        $this->deepCopy();
    }
}

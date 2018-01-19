<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElementRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
abstract class AbstractElement implements ElementInterface
{
    /**
     * Max length of a user inputted field
     *
     * 2^16 bytes
     *
     * Half the size of Shakespeare's play Hamlet
     */
    const MAX_TEXT_LENGTH = 65535;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
    protected $position;

    /**
     * @codeCoverageIgnore
     *
     * @var FormEntity
     *
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(targetEntity="Bayne\FormEntityBundle\Entity\FormEntity", inversedBy="elements")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    protected $formEntity;

    public function __construct(FormEntity $formEntity = null)
    {
        $this->formEntity = $formEntity;

        if ($this->formEntity) {
            $this->formEntity->addElement($this);
        }
    }

    /**
     * @codeCoverageIgnore
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param int $position
     *
     * @return AbstractElement
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param FormEntity $formEntity
     *
     * @return AbstractElement
     */
    public function setFormEntity(FormEntity $formEntity)
    {
        $this->formEntity = $formEntity;
        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return FormEntity
     */
    public function getFormEntity()
    {
        return $this->formEntity;
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
     * Elements must be able to do a deep copy
     *
     * @return void
     */
    public function __clone()
    {
        $this->id = null;
    }
}

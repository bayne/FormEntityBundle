<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer\AnswerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A set of answers to a form entity
 *
 * @ORM\Entity(repositoryClass="Bayne\FormEntityBundle\Entity\FormEntity\Response\ResponseRepository")
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class Response
{
    /**
     * @var int
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    /**
     * @var FormEntity
     *
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(
     *     targetEntity="Bayne\FormEntityBundle\Entity\FormEntity",
     *     fetch="EAGER",
     *     cascade={"merge"}
     * )
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE"
     * )
     */
    private $formEntity;

    /**
     * @var AnswerInterface[]
     *
     * @Assert\NotNull()
     *
     * @ORM\OneToMany(
     *     cascade={"all"},
     *     targetEntity="Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer\AbstractAnswer",
     *     mappedBy="response",
     *     fetch="EAGER"
     * )
     */
    private $answers;

    /**
     * @codeCoverageIgnore
     *
     * @param FormEntity $formEntity
     */
    public function __construct(FormEntity $formEntity)
    {
        $this->formEntity = $formEntity;

        $this->answers = new ArrayCollection();
    }

    /**
     * @codeCoverageIgnore
     *
     * @return AnswerInterface[]|ArrayCollection
     */
    public function getAnswers()
    {
        $answers = new ArrayCollection();
        foreach ($this->answers as $answer) {
            $answers[$answer->getQuestion()->getId()] = $answer;
        }
        return $answers;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param AnswerInterface[] $answers
     *
     * @return Response
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
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
}

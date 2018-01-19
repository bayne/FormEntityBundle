<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\Choice;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\QuestionElementInterface;
use Bayne\FormEntityBundle\Entity\FormEntity\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer\ChoiceAnswerRepository")
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class ChoiceAnswer extends AbstractAnswer
{
    /**
     * @var Choice[]
     *
     * @ORM\ManyToMany(
     *     targetEntity="Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\Choice",
     *     fetch="EAGER",
     *     cascade={"merge"}
     * )
     */
    private $choices;

    /**
     * @codeCoverageIgnore
     *
     * ChoiceAnswer constructor.
     *
     * @param Response $response
     * @param QuestionElementInterface $question
     */
    public function __construct(Response $response, QuestionElementInterface $question)
    {
        parent::__construct($response, $question);
        $this->choices = new ArrayCollection();
    }


    /**
     * @codeCoverageIgnore
     *
     * @return Choice[]|ArrayCollection
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param Choice[]|ArrayCollection $choices
     *
     * @return ChoiceAnswer
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;

        return $this;
    }
}

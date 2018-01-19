<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\AbstractQuestionElement;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\QuestionElementInterface;
use Bayne\FormEntityBundle\Entity\FormEntity\Response;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer\AbstractAnswerRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
abstract class AbstractAnswer implements AnswerInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var AbstractQuestionElement
     *
     * @ORM\ManyToOne(
     *     targetEntity="Bayne\FormEntityBundle\Entity\FormEntity\Element\AbstractElement",
     *     fetch="EAGER",
     *     cascade={"merge"}
     * )
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $question;

    /**
     * @var Response
     *
     * @ORM\ManyToOne(targetEntity="Bayne\FormEntityBundle\Entity\FormEntity\Response", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    protected $response;

    /**
     * AbstractAnswer constructor.
     *
     * @codeCoverageIgnore
     *
     * @param Response $response
     * @param QuestionElementInterface $question
     */
    public function __construct(
        Response $response,
        QuestionElementInterface $question
    ) {
        $this->response = $response;
        $this->question = $question;
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
     * Returns the question that the answer is a response to
     *
     * @codeCoverageIgnore
     *
     * @return AbstractQuestionElement
     */
    public function getQuestion()
    {
        return $this->question;
    }
}

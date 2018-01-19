<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer\TextAnswerRepository")
 * @ORM\Table(options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class TextAnswer extends AbstractAnswer
{
    /**
     * The user entered response for the question
     *
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;

    /**
     * @codeCoverageIgnore
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $value
     *
     * @return TextAnswer
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}

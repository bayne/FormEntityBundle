<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element;

use Bayne\FormEntityBundle\Entity\FormEntity;

interface ElementInterface
{
    /**
     * Get the position of the element on the form
     *
     * @return int
     */
    public function getPosition();

    /**
     * Set the position of the element on the form
     *
     * @param int $position
     *
     * @return int
     */
    public function setPosition($position);

    /**
     * Sets the FormEntity that this element belongs to
     *
     * @param FormEntity $formEntity
     *
     * @return ElementInterface
     */
    public function setFormEntity(FormEntity $formEntity);

    /**
     * Gets the FormEntity that this element belongs to
     *
     * @return FormEntity
     */
    public function getFormEntity();

    /**
     * A unique identifier for the element, used for editting and deleting
     *
     * @return int
     */
    public function getId();

    /**
     * Elements must be able to do a deep copy
     *
     * @return void
     */
    public function __clone();

    /**
     * Returns true if the provided element is a duplicate of this one
     *
     * @param ElementInterface $other
     *
     * @return bool
     */
    public function isDuplicate(ElementInterface $other);
}

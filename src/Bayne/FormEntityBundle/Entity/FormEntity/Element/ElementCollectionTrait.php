<?php

namespace Bayne\FormEntityBundle\Entity\FormEntity\Element;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait ElementCollectionTrait
{

    /**
     * Returns a collection of elements of the given type (class)
     * 
     * @codeCoverageIgnore
     *
     * @param Collection $elements The collection of elements to search through
     * @param string $type
     *
     * @return Collection
     */
    private function getElementsOfType(Collection $elements, $type)
    {
        return $elements->filter(function (ElementInterface $element) use ($type) {
            return get_class($element) === $type;
        });
    }

    /**
     * Set a collection of elements with type $type
     * 
     * @codeCoverageIgnore
     *
     * @param Collection $elements The original collection to replace the elements with
     * @param Collection $newElements A collection of elements with type of $type to add to the elements collection
     * @param string $type The class name of the element to set
     *
     * @return ArrayCollection
     */
    private function replaceElementsOfType(Collection $elements, Collection $newElements, $type)
    {
        $elements = $elements
            ->filter(function (ElementInterface $element) use ($type) {
                return get_class($element) !== $type;
            })
            ->toArray()
        ;

        $elements = array_merge($elements, $newElements->toArray());

        return new ArrayCollection($elements);
    }
}

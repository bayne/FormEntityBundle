<?php

namespace Bayne\FormEntityBundle\View\Common\JSON\Form;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormView;

/**
 * Adds functionality for normalizing a form view.
 */
trait JsonFormViewTrait
{
    /**
     * The set of fields to be normalized from the FormView vars array.
     *
     * @var array
     */
    private $returnedFields = [
        'id',
        'name',
        'type',
        'full_name',
        'checked',
        'errors',
        'value',
        'required',
        'attr',
        'label',
        'decorators'
    ];

    /**
     * Get the normalized form view.
     *
     * @param FormView $formView
     *
     * @return array
     */
    public function getNormalizedFormView(FormView $formView)
    {
        $children = [];

        /** @var FormView $child */
        foreach ($formView->children as $child) {
            $children[$child->vars['name'].'_form'] = $this->getNormalizedFormView($child);
        }

        $vars = array_intersect_key($formView->vars, array_flip($this->returnedFields));

        if (isset($vars['errors'])) {
            $errors = [];
            /** @var FormError $error */
            foreach ($vars['errors'] as $error) {
                $errors[] = $error->getMessage();
            }
            $vars['errors'] = $errors;
        }

        if (isset($vars['value'])) {
            if (is_object($vars['value'])) {
                $vars['value'] = '';
            }
        }

        return [
            'children' => $children,
            'vars' => $vars,
            'count' => $formView->count(),
        ];
    }
}

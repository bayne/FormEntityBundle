<?php

namespace Bayne\FormEntityBundle\Form\FormEntity;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\QuestionElementInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FormEntity $formEntity */
        $formEntity = $options['form_entity'];

        $answersBuilder = $builder->create(
            'answers',
            FormType::class,
            [
                'compound' => true
            ]
        );

        /** @var QuestionElementInterface $element */
        foreach ($formEntity->getQuestionElements() as $element) {
            $answersBuilder->add(
                $element->getName(),
                $element->getType(),
                array_merge(
                    $element->getOptions(),
                    [
                        'response' => $builder->getData()
                    ]
                )
            );
        }

        $builder->add($answersBuilder);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['title'] = $options['title'] ?: $options['form_entity']->getTitle();
        $view->vars['evaluateeName'] = $options['evaluateeName'];
    }


    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        /** @var FormEntity $formEntity */
        $formEntity = $options['form_entity'];
        $view->children['answers']->vars['decorators'] = $formEntity->getDecoratorElements();
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(
            [
                'form_entity',
                'evaluateeName'
            ]
        );

        $resolver->setDefault('title', false);

        $resolver->setDefault(
            'empty_data',
            function (FormInterface $form) {
                return new FormEntity\Response(
                    $form->getConfig()->getOption('form_entity')
                );
            }
        );
    }
}

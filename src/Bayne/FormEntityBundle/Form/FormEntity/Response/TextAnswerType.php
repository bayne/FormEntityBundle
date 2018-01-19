<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Response;

use Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer\TextAnswer;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextAnswerType extends TextareaType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $question = $options['question'];
        $response = $options['response'];

        $builder->addModelTransformer(
            new CallbackTransformer(
                function ($textAnswer) {
                    if ($textAnswer === null) {
                        return '';
                    }

                    return $textAnswer->getValue();
                },
                function ($plainText) use ($question, $response) {
                    $textAnswer = new TextAnswer(
                        $response,
                        $question
                    );

                    $textAnswer->setValue($plainText);

                    return $textAnswer;
                }
            )
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['position'] = $options['question']->getPosition();
        parent::buildView($view, $form, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setRequired(['question', 'response']);
    }
}

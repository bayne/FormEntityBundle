<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Response;

use Bayne\FormEntityBundle\Entity\FormEntity\Response\Answer\ChoiceAnswer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceAnswerType extends ChoiceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $response = $options['response'];
        $question = $options['question'];

        $builder->addModelTransformer(new CallbackTransformer(
            function (ChoiceAnswer $choiceAnswer = null) {
                if ($choiceAnswer === null || $choiceAnswer->getChoices()->count() === 0) {
                    return null;
                }

                if ($choiceAnswer->getQuestion()->isMultiple()) {
                    return $choiceAnswer->getChoices()->toArray();
                } else {
                    return $choiceAnswer->getChoices()->first();
                }
            },
            function ($choices) use ($response, $question) {
                $choiceAnswer = new ChoiceAnswer(
                    $response,
                    $question
                );

                if (is_array($choices)) {
                    $choiceAnswer->setChoices(new ArrayCollection($choices));
                } else {
                    $choiceAnswer->setChoices(new ArrayCollection(array_filter([$choices])));
                }

                return $choiceAnswer;
            }
        ), true);

        parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['position'] = $options['question']->getPosition();
        parent::buildView($view, $form, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('placeholder', false);
        $resolver->setRequired(['question', 'response']);
    }
}

<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\Choice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'label',
                TextType::class
            )
            ->add(
                'position',
                IntegerType::class
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('choice_question');

        $resolver->setDefaults([
            'data_class' => Choice::class,
            'empty_data' => function (FormInterface $form, $viewData) {
                $choiceQuestion = $form->getConfig()->getOption('choice_question');

                if (is_callable($choiceQuestion)) {
                    $choiceQuestion = $choiceQuestion($form, $viewData);
                }

                return new Choice($choiceQuestion);
            }
        ]);
    }
}

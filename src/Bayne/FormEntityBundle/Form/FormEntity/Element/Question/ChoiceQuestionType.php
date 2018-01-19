<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceQuestion;
use Bayne\FormEntityBundle\Form\FormEntity\ElementCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChoiceQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'label',
                TextType::class
            )
            ->add(
                'multiple',
                CheckboxType::class
            )
            ->add(
                'position',
                IntegerType::class
            )
            ->add(
                'choices',
                ElementCollectionType::class,
                [
                    'element_type' => ChoiceType::class,
                    'error_bubbling' => false,
                    'element_options' => [
                        'choice_question' => function (FormInterface $form) {
                            $choiceQuestion = $form->getParent()->getParent()->getData();

                            if ($choiceQuestion === null) {
                                $choiceQuestion = $form->getParent()->getParent()->getConfig()->getEmptyData();
                                $choiceQuestion = $choiceQuestion($form->getParent()->getParent());
                            }

                            return $choiceQuestion;
                        },
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChoiceQuestion::class,
            'empty_data' => function (FormInterface $form) {
                return new ChoiceQuestion(
                    $form->getConfig()->getOption('form_entity')
                );
            }
        ]);

        $resolver->setDefined(['form_entity']);
    }
}

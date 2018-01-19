<?php

namespace Bayne\FormEntityBundle\Form;

use Bayne\FormEntityBundle\Entity\FormEntity;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\HorizontalLine;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\TextDecorator;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\TextQuestion;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator\HorizontalLineType;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\HeaderDecorator;
use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\ChoiceQuestion;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator\HeaderDecoratorType;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator\TextDecoratorType;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Question\ChoiceQuestionType;
use Bayne\FormEntityBundle\Form\FormEntity\Element\Question\TextQuestionType;
use Bayne\FormEntityBundle\Form\FormEntity\ElementCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'attr' => ['maxlength' => FormEntity::MAX_TITLE_LENGTH],
                ]
            )
            ->add(
                'text_question_elements',
                ElementCollectionType::class,
                [
                    'element_type' => TextQuestionType::class,
                    'error_bubbling' => false,
                    'element_options' => [
                        'empty_data' => function (FormInterface $form) {
                            return new TextQuestion($form->getParent()->getParent()->getData());
                        }
                    ]
                ]
            )
            ->add(
                'choice_question_elements',
                ElementCollectionType::class,
                [
                    'element_type' => ChoiceQuestionType::class,
                    'error_bubbling' => false,
                    'element_options' => [
                        'empty_data' => function (FormInterface $form) {
                            // Ensures that child forms use the same empty data objects as this form
                            // Ex. Choice

                            static $choiceQuestion = [];

                            if (!isset($choiceQuestion[spl_object_hash($form)])) {
                                $choiceQuestion[spl_object_hash($form)] = new ChoiceQuestion(
                                    $form->getParent()->getParent()->getData()
                                );
                            }

                            return $choiceQuestion[spl_object_hash($form)];
                        }
                    ]
                ]
            )
            ->add(
                'text_decorator_elements',
                ElementCollectionType::class,
                [
                    'element_type' => TextDecoratorType::class,
                    'element_options' => [
                        'empty_data' => function (FormInterface $form) {
                            return new TextDecorator($form->getParent()->getParent()->getData());
                        }
                    ]
                ]
            )->add(
                'horizontal_line_elements',
                ElementCollectionType::class,
                [
                    'element_type' => HorizontalLineType::class,
                    'element_options' => [
                        'empty_data' => function (FormInterface $form) {
                            return new HorizontalLine($form->getParent()->getParent()->getData());
                        }
                    ]
                ]
            )
            ->add(
                'header_decorator_elements',
                ElementCollectionType::class,
                [
                    'element_type' => HeaderDecoratorType::class,
                    'element_options' => [
                        'empty_data' => function (FormInterface $form) {
                            return new HeaderDecorator($form->getParent()->getParent()->getData());
                        }
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormEntity::class,
        ]);
    }
}

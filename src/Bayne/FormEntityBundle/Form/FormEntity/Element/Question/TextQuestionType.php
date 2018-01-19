<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Question;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Question\TextQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'label',
                TextType::class
            )
            ->add(
                'size',
                IntegerType::class
            )
            ->add(
                'position',
                IntegerType::class
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TextQuestion::class,
        ]);
    }
}

<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\HeaderDecorator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeaderDecoratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'text',
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
        $resolver->setDefaults([
            'data_class' => HeaderDecorator::class,
        ]);
    }
}

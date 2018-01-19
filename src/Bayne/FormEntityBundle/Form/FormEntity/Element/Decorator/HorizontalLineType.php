<?php

namespace Bayne\FormEntityBundle\Form\FormEntity\Element\Decorator;

use Bayne\FormEntityBundle\Entity\FormEntity\Element\Decorator\HorizontalLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorizontalLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'position',
                IntegerType::class
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HorizontalLine::class,
        ]);
    }

}

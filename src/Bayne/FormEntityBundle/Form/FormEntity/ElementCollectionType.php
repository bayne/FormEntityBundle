<?php

namespace Bayne\FormEntityBundle\Form\FormEntity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\EventListener\ResizeFormListener;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementCollectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $resizeListener = new ResizeFormListener(
            $options['element_type'],
            $options['element_options'],
            true,
            true,
            false
        );

        $builder->addEventSubscriber($resizeListener);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'element_type',
        ]);

        $resolver->setDefaults([
            'data_class' => Collection::class,
            'element_options' => [],
            'empty_data' => function () {
                return new ArrayCollection();
            }
        ]);
    }
}

<?php

namespace TS\CYABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageLodgingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lodging', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Lodging',
                'choice_label' => 'nameWithType',
                'label' => 'Lodging',
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'lodging_selector select-select2'],
            ])
            ->add('lodging_price')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\PackageLodging'
        ));
    }
}

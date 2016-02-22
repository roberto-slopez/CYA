<?php

namespace TS\CYABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseRangeWeeksType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('min', IntegerType::class, [
                'required' => false,
                'data' => 0
            ])
            ->add('max', IntegerType::class, [
                'required' => false,
                'data' => 0
            ])
            ->add('greaterThan', IntegerType::class, [
                'required' => false,
                'data' => 0
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\CourseRangeWeeks'
        ));
    }
}

<?php

namespace TS\CYABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('enable')
            ->add('headquarter', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Headquarter',
                'choice_label' => 'name',
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'headquarter_selector select-select2']
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\Exam'
        ));
    }
}

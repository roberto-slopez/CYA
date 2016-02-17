<?php

namespace TS\CYABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TS\CYABundle\Form\EventListener\AddCityFieldSubscriber;

class QuotationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $propertyPathToCity = 'city';
        $builder->addEventSubscriber(new AddCityFieldSubscriber($propertyPathToCity));
        $builder
            ->add('country', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Country',
                'choice_label' => 'name',
                'empty_data' => 'Country',
                'attr' => ['class' => 'country_selector']
            ])
            ->add('headquarter', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Headquarter',
                'choice_label' => 'name'
            ])
            ->add('client', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Client',
                'choice_label' => 'FullName'
            ])
            ->add('seller', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Seller',
                'choice_label' => 'FullName'
            ])
            ->add('lodging', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Lodging',
                'choice_label' => 'name'
            ])
            ->add('service', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Service',
                'choice_label' => 'name'
            ])
            ->add('optionalService', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\OptionalService',
                'choice_label' => 'name'
            ])
            ->add('course', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Course',
                'choice_label' => 'name'
            ])
            ->add('exam', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Exam',
                'choice_label' => 'name'
            ])
            ->add('semanas', IntegerType::class, [
                'label' => 'Weeks'
            ])
            ->add('note')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\Quotation'
        ));
    }
}

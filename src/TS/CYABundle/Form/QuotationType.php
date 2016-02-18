<?php

namespace TS\CYABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TS\CYABundle\Form\EventListener\AddCityFieldSubscriber;
use TS\CYABundle\Form\EventListener\AddHeadquarterFieldSubscriber;
use TS\CYABundle\Form\ClientType;
use TS\CYABundle\Form\OptionalServiceType;

class QuotationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new AddCityFieldSubscriber('city'));
        $builder->addEventSubscriber(new AddHeadquarterFieldSubscriber('headquarter'));
        $builder
            ->add('country', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Country',
                'choice_label' => 'name',
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'country_selector']
            ])
            ->add('client', CollectionType::class, [
                'entry_type' => ClientType::class,
                'allow_add' => true
            ])
            ->add('lodging', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Lodging',
                'choice_label' => 'name'
            ])
            ->add('service', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Service',
                'choice_label' => 'name'
            ])
            ->add('optionalService', CollectionType::class, [
                'entry_type' => OptionalServiceType::class,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true
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

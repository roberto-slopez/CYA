<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TS\CYABundle\Form\EventListener\AddCityFieldSubscriber;
use TS\CYABundle\Form\EventListener\AddCourseFieldSubscriber;
use TS\CYABundle\Form\EventListener\AddDiscretionarySpendingFieldSubscriber;
use TS\CYABundle\Form\EventListener\AddHeadquarterFieldSubscriber;
use TS\CYABundle\Form\ClientType;
use TS\CYABundle\Form\EventListener\AddLodgingFieldSubscriber;
use TS\CYABundle\Form\EventListener\AddPromocionFieldSubscriber;
use TS\CYABundle\Form\EventListener\AddServiceFieldSubscriber;

/**
 * Class QuotationType
 * @package TS\CYABundle\Form
 */
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
        $builder->addEventSubscriber(new AddLodgingFieldSubscriber('lodging'));
        $builder->addEventSubscriber(new AddCourseFieldSubscriber('course'));
        $builder->addEventSubscriber(new AddServiceFieldSubscriber('service'));
        $builder->addEventSubscriber(new AddDiscretionarySpendingFieldSubscriber('discretionarySpending'));
        $builder
            ->add('country', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Country',
                'required' => true,
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('country')
                        ->orderBy('country.name', 'ASC');
                    return $qb;
                },
                'choice_label' => 'name',
                'placeholder' => 'Choose an option',
                'attr' => ['class' => 'country_selector select-select2']
            ])
            ->add('client', ClientType::class)
            ->add('semanas', IntegerType::class, [
                'required' => true,
                'label' => 'Weeks'
            ])
            ->add('without_lodging', CheckboxType::class)
            ->add('semanas_lodging', IntegerType::class, [
                'required' => false,
                'label' => 'Weeks lodging'
            ])
            ->add('summer_supplement', IntegerType::class, [
                'required' => false,
                'label' => 'Summer supplement weeks'
            ])
            ->add('manualMultiplier', CollectionType::class, [
                'required' => false,
                'entry_type' => ManualMultiplierType::class,
                'label' => ' ',
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true
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

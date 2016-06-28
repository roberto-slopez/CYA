<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ManualMultiplierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service', EntityType::class, [
                'class' => 'TSCYABundle:Service',
                'placeholder' => 'Choose an option',
                'required' => true,
                'label' => 'Service',
                'choice_label' => 'name',
                'attr' => ['class' => 'city_selector select-select2'],
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('service')
                        ->where('service.manual_multiplier = :manual_multiplier')
                        ->setParameter('manual_multiplier', true)
                        ->orderBy('service.name', 'ASC');

                    return $qb;
                },
            ])
            ->add('quantity', NumberType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\ManualMultiplier'
        ));
    }
}

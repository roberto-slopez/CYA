<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TS\CYABundle\Entity\Service;

class ServiceType extends AbstractType
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
            ->add('type', ChoiceType::class, [
                'choices' => [
                    Service::OPTIONAL => Service::OPTIONAL,
                    Service::REQUIRED => Service::REQUIRED
                ]
            ])
            ->add('headquarter', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Headquarter',
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('headquarter')
                        ->orderBy('headquarter.name', 'ASC');
                    return $qb;
                },
                'choice_label' => 'name',
                'attr' => ['class' => 'select-select2']
            ])
            ->add('charge_per_week', CheckboxType::class, [
                'required' => false
            ])
            ->add('uses_limit_weeks', CheckboxType::class, [
              'required' => false
            ])
            ->add('limit_week', NumberType::class,[
              'required' => false
            ])
            ->add('is_health_coverage', CheckboxType::class,[
              'required' => false
            ])
            ->add('summer_supplement', CheckboxType::class,[
              'required' => false
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\Service'
        ));
    }
}

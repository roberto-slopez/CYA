<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscretionarySpendingType extends AbstractType
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
            ->add('valueVisa', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('valueAdicional', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('valueShipping', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('coin', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Coin',
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('coin')
                        ->orderBy('coin.name', 'ASC');
                    return $qb;
                },
                'choice_label' => 'name',
                'attr' => ['class' => 'select-select2']
            ])
            ->add('country', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Country',
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('country')
                        ->orderBy('country.name', 'ASC');
                    return $qb;
                },
                'choice_label' => 'name',
                'attr' => ['class' => 'select-select2']
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\DiscretionarySpending'
        ));
    }
}

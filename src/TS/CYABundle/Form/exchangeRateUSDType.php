<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class exchangeRateUSDType
 * @package TS\CYABundle\Form
 */
class exchangeRateUSDType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('local', MoneyType::class, [
                'currency' => 'USD',
                'scale' => 4,
                'label' => 'Amount'
            ])
            ->add('date', DateType::class, [
                'data' => new \DateTime('today'),
            ])
            ->add('expiration', DateType::class, [
                'data' => new \DateTime('today'),
            ])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\exchangeRateUSD'
        ));
    }
}

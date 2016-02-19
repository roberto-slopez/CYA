<?php

namespace TS\CYABundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'choice_label' => 'name'
            ])
            ->add('local', MoneyType::class, [
                'currency' => 'USD',
                'label' => 'Amount'
            ])
            ->add('date', DateType::class, [
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

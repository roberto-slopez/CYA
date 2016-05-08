<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use TS\CYABundle\Entity\Lodging;

class LodgingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    Lodging::SIMPLE => Lodging::SIMPLE,
                    Lodging::DOUBLE => Lodging::DOUBLE,
                    Lodging::TRIPLE => Lodging::TRIPLE,
                ]
            ])
            ->add('price_per_week', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('summer_price', MoneyType::class, [
                'currency' => 'USD'
            ])
            ->add('description')
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
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\Lodging'
        ));
    }
}

<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromocionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('expiration', DateType::class)
            ->add('exam', EntityType::class, [
                'class' => 'TS\CYABundle\Entity\Exam',
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('exam')
                        ->join('exam.headquarter', 'headquarter')
                        ->orderBy('headquarter.name', 'ASC');
                    return $qb;
                },
                'choice_label' => 'label',
                'attr' => ['class' => 'select-select2']
            ])
            ->add('percentage', PercentType::class)
            ->add('enable')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\CYABundle\Entity\Promocion'
        ));
    }
}

<?php

namespace TS\CYABundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TS\CYABundle\Entity\Headquarter;

class HeadquarterType extends AbstractType
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
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    Headquarter::SCHOOL => Headquarter::SCHOOL,
                    Headquarter::COLLEGE => Headquarter::COLLEGE,
                    Headquarter::OTHERS => Headquarter::OTHERS,
                ]
            ])
            ->add('city',  EntityType::class, [
                'class' => 'TS\CYABundle\Entity\City',
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('city')
                        ->orderBy('city.name', 'ASC');
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
            'data_class' => 'TS\CYABundle\Entity\Headquarter'
        ));
    }
}

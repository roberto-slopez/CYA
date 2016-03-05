<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 20/02/16
 * Time: 10:36 AM
 */

namespace TS\CYABundle\Form\EventListener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use TS\CYABundle\Entity\Package;

/**
 * Class AddPackageFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddPackageFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToPackage;

    public function __construct($propertyPathToPackage)
    {
        $this->propertyPathToPackage = $propertyPathToPackage;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }


    /**
     * @param FormInterface $form
     * @param $headquarter
     */
    private function addPackageForm(FormInterface $form, $headquarter)
    {
        $formOptions = [
            'class' => 'TS\CYABundle\Entity\Package',
            'placeholder' => 'Choose an option',
            'label' => 'Package',
            'attr' => ['class' => 'package_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($headquarter) {
                $qb = $repository->createQueryBuilder('package')
                    ->innerJoin('package.headquarter', 'headquarter')
                    ->where('headquarter.id = :headquarter_id')
                    ->setParameter('headquarter_id', $headquarter)
                    ->orderBy('package.name', 'ASC');

                return $qb;
            },
        ];

        $form->add($this->propertyPathToPackage, EntityType::class, $formOptions);
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        $package = $accessor->getValue($data, $this->propertyPathToPackage);
        $headquartersId = ($package) ? $package->getHeadquartersId() : null;
        $this->addPackageForm($form, $headquartersId);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $headquartersId = array_key_exists('headquarter', $data) ? $data['headquarter'] : null;
        $this->addPackageForm($form, $headquartersId);
    }
}
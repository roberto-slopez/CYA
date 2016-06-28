<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 16/02/16
 * Time: 07:22 PM
 */

namespace TS\CYABundle\Form\EventListener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use TS\CYABundle\Entity\Lodging;

/**
 * Class AddLodgingFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddLodgingFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToLodging;

    public function __construct($propertyPathToLodging)
    {
        $this->propertyPathToLodging = $propertyPathToLodging;
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
    private function addLodgingForm(FormInterface $form, $headquarter)
    {
        $formOptions = [
            'class' => 'TS\CYABundle\Entity\Lodging',
            'choice_label' => 'nameType',
            'required' => false,
            'placeholder' => 'Choose an option',
            'label' => 'Lodging',
            'attr' => ['class' => 'lodging_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($headquarter) {
                $qb = $repository->createQueryBuilder('lodging')
                    ->innerJoin('lodging.headquarter', 'headquarter')
                    ->where('headquarter.id = :headquarter_id')
                    ->setParameter('headquarter_id', $headquarter)
                    ->orderBy('lodging.name', 'ASC');

                return $qb;
            },
        ];

        $form->add($this->propertyPathToLodging, EntityType::class, $formOptions);
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
        $lodging = $accessor->getValue($data, $this->propertyPathToLodging);
        $headquartersId = ($lodging) ? $lodging->getHeadquartersId() : null;
        $this->addLodgingForm($form, $headquartersId);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $headquartersId = array_key_exists('headquarter', $data) ? $data['headquarter'] : null;
        $this->addLodgingForm($form, $headquartersId);
    }
}
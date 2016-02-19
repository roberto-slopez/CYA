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
use TS\CYABundle\Entity\Service;

/**
 * Class AddServiceFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddServiceFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToService;

    public function __construct($propertyPathToService)
    {
        $this->propertyPathToService = $propertyPathToService;
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
    private function addServiceForm(FormInterface $form, $headquarter)
    {
        $formOptions = [
            'class' => 'TS\CYABundle\Entity\Service',
            'multiple' => true,
            //'expanded' => true,
            'placeholder' => 'Choose an option',
            'label' => 'Service',
            'attr' => ['class' => 'service_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($headquarter) {
                $qb = $repository->createQueryBuilder('service')
                    ->innerJoin('service.headquarter', 'headquarter')
                    ->where('headquarter.id = :headquarter_id')
                    ->setParameter('headquarter_id', $headquarter);

                return $qb;
            },
        ];

        $form->add($this->propertyPathToService, EntityType::class, $formOptions);
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
        $service = $accessor->getValue($data, $this->propertyPathToService);
        $service = ($service) ? $service->getHeadquartersId() : null;
        $this->addServiceForm($form, $service);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $service = array_key_exists('headquarter', $data) ? $data['headquarter'] : null;
        $this->addServiceForm($form, $service);
    }
}
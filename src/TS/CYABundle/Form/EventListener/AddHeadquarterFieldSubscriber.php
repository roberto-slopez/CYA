<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 16/02/16
 * Time: 07:21 PM
 */

namespace TS\CYABundle\Form\EventListener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use TS\CYABundle\Entity\City;
use TS\CYABundle\Entity\Headquarter;

/**
 * Class AddHeadquarterFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddHeadquarterFieldSubscriber implements  EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToHeadquarter;

    public function __construct($propertyPathToHeadquarter)
    {
        $this->propertyPathToHeadquarter = $propertyPathToHeadquarter;
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
     * @param $city
     */
    private function addHeadquarterForm(FormInterface $form, $city)
    {
        $formOptions = [
            'class' => 'TS\CYABundle\Entity\Headquarter',
            'placeholder' => 'Choose an option',
            'label' => 'Headquarter',
            'attr' => ['class' => 'headquarter_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($city) {
                $qb = $repository->createQueryBuilder('headquarter')
                    ->innerJoin('headquarter.city', 'city')
                    ->where('city.id = :city_id')
                    ->setParameter('city_id', $city)
                    ->orderBy('headquarter.name', 'ASC');

                return $qb;
            },
        ];

        $form->add($this->propertyPathToHeadquarter, EntityType::class, $formOptions);
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
        $headquarter = $accessor->getValue($data, $this->propertyPathToHeadquarter);
        $city = ($headquarter) ? $headquarter->getCity()->getId() : null;
        $this->addHeadquarterForm($form, $city);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $city = array_key_exists('city', $data) ? $data['city'] : null;
        $this->addHeadquarterForm($form, $city);
    }
}
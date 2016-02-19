<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 16/02/16
 * Time: 07:20 PM
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
use TS\CYABundle\Entity\Country;

/**
 * Class AddCityFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddCityFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToCity;

    public function __construct($propertyPathToCity)
    {
        $this->propertyPathToCity = $propertyPathToCity;
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
     * @param $country
     */
    private function addCityForm(FormInterface $form, $country)
    {
        $formOptions = [
            'class' => 'TSCYABundle:City',
            'placeholder' => 'Choose an option',
            'label' => 'City',
            'attr' => ['class' => 'city_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($country) {
                $qb = $repository->createQueryBuilder('city')
                    ->where('city.country_id = :country')
                    ->setParameter('country', $country);

                return $qb;
            },
        ];

        $form->add($this->propertyPathToCity, EntityType::class, $formOptions);
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
        $city = $accessor->getValue($data, $this->propertyPathToCity);
        $country = ($city) ? $city->getCountryId() : null;
        $this->addCityForm($form, $country);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $country = array_key_exists('country', $data) ? $data['country'] : null;
        $this->addCityForm($form, $country);
    }
}
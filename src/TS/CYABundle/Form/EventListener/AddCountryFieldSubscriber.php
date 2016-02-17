<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 16/02/16
 * Time: 07:20 PM
 */

namespace TS\CYABundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;

/**
 * Class AddCountryFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddCountryFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToCity;

    /**
     * AddCountryFieldSubscriber constructor.
     * @param $propertyPathToCity
     */
    public function __construct($propertyPathToCity)
    {
        $this->propertyPathToCity = $propertyPathToCity;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        );
    }

    /**
     * @param $form
     * @param null $country
     */
    private function addCountryForm($form, $country = null)
    {
        $formOptions = array(
            'class' => 'MainBundle:Country',
            'mapped' => false,
            'label' => 'País',
            'empty_value' => 'País',
            'attr' => array(
                'class' => 'country_selector',
            ),
        );
        if ($country) {
            $formOptions['data'] = $country;
        }
        $form->add('country', 'entity', $formOptions);
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
        $accessor = PropertyAccess::getPropertyAccessor();
        $city = $accessor->getValue($data, $this->propertyPathToCity);
        $country = ($city) ? $city->getProvince()->getCountry() : null;
        $this->addCountryForm($form, $country);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $this->addCountryForm($form);
    }
}
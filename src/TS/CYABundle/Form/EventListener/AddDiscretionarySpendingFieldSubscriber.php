<?php
/**
 * Created by PhpStorm.
 * User: tscompany
 * Date: 13/03/16
 * Time: 12:35 PM
 */

namespace TS\CYABundle\Form\EventListener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;

class AddDiscretionarySpendingFieldSubscriber implements  EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToDiscretionarySpending;

    public function __construct($propertyPathToDiscretionarySpending)
    {
        $this->propertyPathToDiscretionarySpending = $propertyPathToDiscretionarySpending;
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
    private function addDiscretionarySpendingForm(FormInterface $form, $country)
    {
        $formOptions = [
            'class' => 'TSCYABundle:DiscretionarySpending',
            'placeholder' => 'Choose an option',
            'label' => 'Discretionary Spending',
            'attr' => ['class' => 'discretionary_spending_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($country) {
                $qb = $repository->createQueryBuilder('ds')
                    ->join('ds.country', 'country')
                    ->where('country.id = :country')
                    ->setParameter('country', $country)
                    ->orderBy('ds.name', 'ASC');

                return $qb;
            },
        ];

        $form->add($this->propertyPathToDiscretionarySpending, EntityType::class, $formOptions);
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
        $discretionarySpending = $accessor->getValue($data, $this->propertyPathToDiscretionarySpending);
        $country = ($discretionarySpending) ? $discretionarySpending->getCountry()->getId() : null;
        $this->addDiscretionarySpendingForm($form, $country);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $country = array_key_exists('country', $data) ? $data['country'] : null;
        $this->addDiscretionarySpendingForm($form, $country);
    }
}
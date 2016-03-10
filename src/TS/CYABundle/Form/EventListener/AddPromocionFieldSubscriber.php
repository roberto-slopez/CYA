<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 9/03/16
 * Time: 08:10 PM
 */

namespace TS\CYABundle\Form\EventListener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use TS\CYABundle\Entity\Promocion;

/**
 * Class AddPromocionFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddPromocionFieldSubscriber  implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToPromocion;

    public function __construct($propertyPathToPromocion)
    {
        $this->propertyPathToPromocion = $propertyPathToPromocion;
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
     * @param $course
     */
    private function addPromocionForm(FormInterface $form, $course)
    {
        $formOptions = [
            'class' => 'TS\CYABundle\Entity\Promocion',
            'required' => false,
            'placeholder' => 'Choose an option',
            'label' => 'Promocion',
            'attr' => ['class' => 'promocion_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($course) {
                $qb = $repository->createQueryBuilder('promocion')
                    ->innerJoin('promocion.course', 'course')
                    ->where('course.id = :course_id')
                    ->setParameter('course_id', $course)
                    ->orderBy('promocion.name', 'ASC');

                return $qb;
            },
        ];

        $form->add($this->propertyPathToPromocion, EntityType::class, $formOptions);
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
        $promocion = $accessor->getValue($data, $this->propertyPathToPromocion);
        $courseId = ($promocion) ? $promocion->getCourse()->getId() : null;

        $this->addPromocionForm($form, $courseId);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $courseId = array_key_exists('course', $data) ? $data['course'] : null;
        $this->addPromocionForm($form, $courseId);
    }
}
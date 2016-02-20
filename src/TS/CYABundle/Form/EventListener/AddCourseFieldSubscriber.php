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
use TS\CYABundle\Entity\Course;

/**
 * Class AddCourseFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddCourseFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToCuorse;

    public function __construct($propertyPathToCuorse)
    {
        $this->propertyPathToCuorse = $propertyPathToCuorse;
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
    private function addCourseForm(FormInterface $form, $headquarter)
    {
        $formOptions = [
            'class' => 'TS\CYABundle\Entity\Course',
            'placeholder' => 'Choose an option',
            'label' => 'Course',
            'attr' => ['class' => 'course_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($headquarter) {
                $qb = $repository->createQueryBuilder('course')
                    ->innerJoin('course.headquarter', 'headquarter')
                    ->where('headquarter.id = :headquarter_id')
                    ->setParameter('headquarter_id', $headquarter);

                return $qb;
            },
        ];

        $form->add($this->propertyPathToCuorse, EntityType::class, $formOptions);
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
        $course = $accessor->getValue($data, $this->propertyPathToCuorse);
        $headquartersId = ($course) ? $course->getHeadquartersId() : null;
        $this->addCourseForm($form, $headquartersId);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $headquartersId = array_key_exists('headquarter', $data) ? $data['headquarter'] : null;
        $this->addCourseForm($form, $headquartersId);
    }
}
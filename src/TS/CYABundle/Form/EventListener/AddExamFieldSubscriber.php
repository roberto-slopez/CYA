<?php
/**
 * Created by @roberto-slopez.
 * User: tscompany
 * Date: 20/02/16
 * Time: 10:37 AM
 */

namespace TS\CYABundle\Form\EventListener;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;
use TS\CYABundle\Entity\Exam;

/**
 * Class AddExamFieldSubscriber
 * @package TS\CYABundle\Form\EventListener
 */
class AddExamFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $propertyPathToExam;

    public function __construct($propertyPathToExam)
    {
        $this->propertyPathToExam = $propertyPathToExam;
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
    private function addExamForm(FormInterface $form, $headquarter)
    {
        $formOptions = [
            'class' => 'TS\CYABundle\Entity\Exam',
            'placeholder' => 'Choose an option',
            'label' => 'Exam',
            'attr' => ['class' => 'exam_selector select-select2'],
            'query_builder' => function (EntityRepository $repository) use ($headquarter) {
                $qb = $repository->createQueryBuilder('exam')
                    ->innerJoin('exam.headquarter', 'headquarter')
                    ->where('headquarter.id = :headquarter_id')
                    ->setParameter('headquarter_id', $headquarter);

                return $qb;
            },
        ];

        $form->add($this->propertyPathToExam, EntityType::class, $formOptions);
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
        $exam = $accessor->getValue($data, $this->propertyPathToExam);
        $headquartersId = ($exam) ? $exam->getHeadquartersId() : null;
        $this->addExamForm($form, $headquartersId);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $headquartersId = array_key_exists('headquarter', $data) ? $data['headquarter'] : null;
        $this->addExamForm($form, $headquartersId);
    }
}
<?php

namespace TS\Cian\MainBundle\Doctrine\Behaviors\Loggable;

use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;

use Knp\DoctrineBehaviors\ORM\AbstractSubscriber,
    Knp\DoctrineBehaviors\ORM\Loggable\LoggableSubscriber as BaseLoggableListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Doctrine\Bundle\DoctrineBundle\Registry;

use Doctrine\Common\EventSubscriber,
    Doctrine\ORM\Event\OnFlushEventArgs,
    Doctrine\ORM\Events;

use TS\CYABundle\Doctrine\Behaviors\Loggable\Entity\EntityLogEntry;

/**
 * TODO: implementar.
 *
 * Class LoggableListener
 * @package TS\CYABundle\Doctrine\Behaviors\Loggable
 */
class LoggableListener extends BaseLoggableListener
{
    private $doctrine;

    private $manualFlush = false;

    /**
     * @param callable
     */
    public function __construct(ClassAnalyzer $classAnalyzer, $isRecursive, Registry $doctrine)
    {
        parent::__construct($classAnalyzer, $isRecursive, function() {});

        $this->doctrine = $doctrine;
    }

    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $em            = $eventArgs->getEntityManager();
        $entity        = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));

        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $this->log(array(
                'tabla' => $classMetadata->getTableName(),
                'id' => $entity->getId(),
                'mensaje' => $entity->getCreateLogMessage(),
                'user' => $entity->getUpdatedBy()
            ));
        }

        return $this->logChangeSet($eventArgs);
    }

    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        return $this->logChangeSet($eventArgs);
    }

    /**
     * Logs entity changeset
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function logChangeSet(LifecycleEventArgs $eventArgs)
    {
        $em            = $eventArgs->getEntityManager();
        $uow           = $em->getUnitOfWork();
        $entity        = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));

        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $uow->computeChangeSet($classMetadata, $entity);
            $changeSet = $uow->getEntityChangeSet($entity);

            $user = $entity->getUpdatedBy();

            $this->log(array(
                'tabla' => $classMetadata->getTableName(),
                'id' => $entity->getId(),
                'mensaje' => $this->getUpdateLogMessage($changeSet, $entity),
                'user' => $entity->getUpdatedBy()
            ));
        }
    }

    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $em            = $eventArgs->getEntityManager();
        $entity        = $eventArgs->getEntity();
        $classMetadata = $em->getClassMetadata(get_class($entity));

        if ($this->isEntitySupported($classMetadata->reflClass)) {
            $this->log(array(
                'tabla' => $classMetadata->getTableName(),
                'id' => $entity->getId(),
                'mensaje' => $entity->getRemoveLogMessage(),
                'user' => $entity->getUpdatedBy()
            ));
        }
    }

    /**
     * Checks if entity supports Loggable
     *
     * TODO: This listener uses both the Loggable trait and the Blameable trait,
     * so this method should check for both
     *
     * @param  ReflectionClass $reflClass
     * @return boolean
     */
    protected function isEntitySupported(\ReflectionClass $reflClass)
    {
        return $this->getClassAnalyzer()->hasTrait($reflClass, 'TS\Cian\MainBundle\Doctrine\Behaviors\Loggable\Loggable', $this->isRecursive);
    }

    public function getSubscribedEvents()
    {
        $events = [
            Events::postPersist,
            Events::postUpdate,
            Events::preRemove,
        ];

        return $events;
    }

    private function getUpdateLogMessage(array $changeSets = [], $entity)
    {
        $message = [];
        foreach ($changeSets as $property => $changeSet) {
            for ($i = 0 , $s = sizeof($changeSet); $i < $s ; $i++) {
                if ($changeSet[$i] instanceof \DateTime) {
                    $changeSet[$i] = $changeSet[$i]->format("Y-m-d H:i:s");
                }

                if (is_array($changeSet[$i])) {
                    $changeSet[$i] = print_r($changeSet[$i], true);
                }
            }

            $message[] = sprintf(
                'Property "%s" changed from "%s" to "%s"',
                $property,
                $changeSet[0],
                $changeSet[1]
            );
        }

        return implode("\n", $message);
    }

    /**
     *     - tabla
     *     - id
     *     - mensaje
     *     - user
     * @param array $logInfo
     */
    private function log(array $logInfo)
    {
        $em = $this->doctrine->getManager('log');

        $usuarioString = null;
        if (isset($logInfo['user'])) {
            $usuarioString = $logInfo['user']->getUsername();
        }

        $logEntry = new EntityLogEntry(
            $logInfo['tabla'],
            $logInfo['id'],
            $logInfo['mensaje'],
            new \DateTime('now'),
            $usuarioString
        );

        $em->persist($logEntry);
        if (!$this->manualFlush) {
            $em->flush();
            $em->clear();
        }
    }

    public function setManualFlush($manualFlush)
    {
        $this->manualFlush = $manualFlush;
    }

    public function flush()
    {
        $em = $this->doctrine->getManager('log');
        $em->flush();
        $em->clear();
    }

    public function getManager()
    {
        return $this->doctrine->getManager('log');
    }
}

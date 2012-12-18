<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\EventListener;

use JAL\Bundle\TaskBundle\Event\GetTaskEvent;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use JAL\Bundle\TaskBundle\Model\TaskHistoryManagerInterface;

/**
 * TaskHistoryListener
 *
 */
class TaskHistoryListener
{
    protected $logger;

    protected $manager;

    protected $previousTaskState;

    public function __construct(TaskHistoryManagerInterface $manager, LoggerInterface $logger)
    {
        $this->manager = $manager;
        $this->logger  = $logger;
    }

    public function onPreTaskStateChanged(GetTaskEvent $event)
    {
        $task  = $event->getTask();
        $this->previousTaskState = $task->getState();

        $this
            ->logger
            ->info("Saving temporal state '{$this->previousTaskState->getName()}' of task '{$task->getName()}'");
    }

    public function onPostTaskStateChanged(GetTaskEvent $event)
    {
        $task  = $event->getTask();
        $user  = $event->getUser();
        $state = $task->getState();

        $taskHistory = $this->manager->createTaskHistory($task, $state, $user);

        $this->manager->updateTaskHistory($taskHistory);

        $this
            ->logger
            ->info("Task state of '{$task->getName()}' has been changed from '{$this->previousTaskState->getName()}' to '{$state->getName()}'");
    }
}

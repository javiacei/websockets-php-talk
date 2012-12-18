<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use JAL\Bundle\TaskBundle\Event\GetTaskEvent;
use JAL\Bundle\TaskBundle\Event\TaskEvents;

class TaskManager implements TaskManagerInterface
{
    protected $om;
    protected $repository;
    protected $class;
    protected $dispatcher;

    public function __construct(ObjectManager $om, $class, EventDispatcherInterface $dispatcher)
    {
        $this->om         = $om;
        $this->class      = $class;
        $this->repository = $om->getRepository($class);
        $this->dispatcher = $dispatcher;
    }

    public function createTask()
    {
        return new $this->class;
    }

    public function updateTask(TaskInterface $task, $andFlush = true)
    {
        $this->om->persist($task);

        if (true === $andFlush) {
            $this->om->flush();
        }
    }

    public function removeTask(TaskInterface $task)
    {
        $this->om->remove($task);
        $this->om->flush();
    }

    public function changeStateTaskByUser(TaskInterface $task, StateInterface $state, UserInterface $user)
    {
        if (false === $task->getUsers()->contains($user)) {
            // Insert that a new user has been working ($stateName) in this task
            $task->addUser($user);
        }

        $event = new GetTaskEvent($task, $user);

        // Pre task state changed
        $this->dispatcher->dispatch(TaskEvents::PRE_TASK_STATE_CHANGED, $event);

        $task->setState($state);

        // Post task state changed
        $this->dispatcher->dispatch(TaskEvents::POST_TASK_STATE_CHANGED, $event);
        $this->om->persist($task);
        $this->om->flush();
    }

    public function findAllTasks(array $orderBy = array())
    {
        return $this->repository->findBy(array(), $orderBy);
    }
}

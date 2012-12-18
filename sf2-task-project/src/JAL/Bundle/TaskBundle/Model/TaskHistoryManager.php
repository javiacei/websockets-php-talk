<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;

class TaskHistoryManager implements TaskHistoryManagerInterface
{
    protected $om;
    protected $repository;
    protected $class;
    protected $dispatcher;

    public function __construct(ObjectManager $om, $class)
    {
        $this->om         = $om;
        $this->class      = $class;
        $this->repository = $om->getRepository($class);
    }

    public function createTaskHistory(TaskInterface $task, StateInterface $state, UserInterface $user)
    {
        $taskHistory = new $this->class;

        $taskHistory->setTask($task);
        $taskHistory->setUser($user);
        $taskHistory->setState($state);
        $taskHistory->setCreatedAt(new \DateTime('now'));

        return $taskHistory;
    }

    public function updateTaskHistory(TaskHistoryInterface $taskHistory, $andFlush = true)
    {
        $this->om->persist($taskHistory);

        if (true === $andFlush) {
            $this->om->flush();
        }
    }

    public function getLastTaskModified()
    {
        $histories = $this->repository->findBy(array(), array('createdAt' => 'desc'), 1);
        $history = \reset($histories);

        if (null !== $history) {
            return $history->getCreatedAt();
        }

        return null;
    }
}

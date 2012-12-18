<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use JAL\Bundle\TaskBundle\Model\UserInterface;
use JAL\Bundle\TaskBundle\Model\TaskInterface;

/**
 * GetTaskEvent
 *
 */
class GetTaskEvent extends Event
{
    protected $user;
    protected $task;

    public function __construct(TaskInterface $task, UserInterface $user)
    {
        $this->task  = $task;
        $this->user  = $user;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function getUser()
    {
        return $this->user;
    }
}

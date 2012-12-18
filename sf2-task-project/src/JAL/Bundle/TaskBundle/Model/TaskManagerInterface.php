<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Model;

interface TaskManagerInterface
{
    public function createTask();

    public function updateTask(TaskInterface $task, $andFlush = true);

    public function removeTask(TaskInterface $task);

    public function changeStateTaskByUser(TaskInterface $task, StateInterface $state, UserInterface $user);
}

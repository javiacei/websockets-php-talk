<?php

namespace JAL\Bundle\TaskBundle\Event;

/*
 * TaskEvents
 */
final class TaskEvents
{
    /**
     *
     */
    const PRE_TASK_STATE_CHANGED  = 'jal_task.pre_task_state_changed';

    /**
     *
     */
    const POST_TASK_STATE_CHANGED = 'jal_task.post_task_state_changed';
}

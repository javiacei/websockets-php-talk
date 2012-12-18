<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * @Route("/list", name="task_list")
     * @Template()
     */
    public function listAction()
    {
        // Services
        $manager        = $this->get('jal_task.task_manager');
        $historyManager = $this->get('jal_task.task_history_manager');

        $tasks = $manager->findAllTasks(array('priority' => 'desc'));

        return array('tasks' => $tasks);
    }

    /**
     * @Route("/task/{id}/change/{state}", name="task_change_state")
     */
    public function changeStateAction($id, $state)
    {
        // Services
        $em = $this->getDoctrine()->getManager();
        $manager = $this->get('jal_task.task_manager');

        // Params
        $task = $em->getRepository('JALTaskBundle:Task')->findOneById($id);
        $state = $em->getRepository('JALTaskBundle:State')->findOneByName($state);

        $manager->changeStateTaskByUser($task, $state, $this->getUser());

        // Paso 1
        //return $this->redirect($this->generateUrl('task_list'));

        // Paso 2
        //return new Response(\json_encode(array(
        //    'state'    => $state->getName(),
        //    'username' => $this->getUser()->getUsername(),
        //    'task_id'  => $task->getId()
        //)), 200, array( 'Content-Type' => 'application/json'));

        // Paso 3
        $queue = new \JAL\Bundle\TaskBundle\ZeroMQ\Queue();
        $queue->send(array(
            'state'    => $state->getName(),
            'username' => $this->getUser()->getUsername(),
            'task_id'  => $task->getId()
        ));

        return new Response(\json_encode(array(
        )), 200, array( 'Content-Type' => 'application/json'));
    }

    public function createAction()
    {
    }
}

<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JAL\Bundle\TaskBundle\Entity\TaskHistory;

class LoadTaskHistoryData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        return;
        $faker = \Faker\Factory::create();

        $userRepository  = $manager->getRepository('JALTaskBundle:User');
        $stateRepository = $manager->getRepository('JALTaskBundle:State');
        $taskRepository  = $manager->getRepository('JALTaskBundle:Task');

        $users = $userRepository->findAll();
        $user  = \reset($users);

        $tasks = $taskRepository->findAll();
        $state = $stateRepository->findOneByName('todo'); // All tasks in todo state

        foreach ($tasks as $task) {
            $taskHistory = new TaskHistory();
            $taskHistory->setUser($user);
            $taskHistory->setTask($task);
            $taskHistory->setState($state);
            $taskHistory->setCreatedAt($faker->dateTime);

            $manager->persist($taskHistory);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}

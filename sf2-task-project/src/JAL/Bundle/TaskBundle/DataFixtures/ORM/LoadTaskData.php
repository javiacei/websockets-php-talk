<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use JAL\Bundle\TaskBundle\Entity\Task;

class LoadTaskData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    const TASKS_NUMBER = 30;

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $unitNames = array('S', 'M', 'L', 'XL');

        $faker = \Faker\Factory::create();

        $userManager     = $this->container->get('fos_user.user_manager');
        $stateRepository = $manager->getRepository('JALTaskBundle:State');
        $unitRepository  = $manager->getRepository('JALTaskBundle:Unit');

        $users = $userManager->findUsers();
        $user  = \reset($users);

        $state = $stateRepository->findOneByName('todo');

        $tasks = new \SplObjectStorage();
        for ($i = 0; $i < self::TASKS_NUMBER; $i++) {
            $unitRandomKey = \array_rand($unitNames);
            $unit = $unitRepository->findOneByName($unitNames[$unitRandomKey]);

            $task = new Task();
            $task->setName($faker->name);
            $task->setState($state);
            $task->setUnit($unit);
            $task->setPriority(\rand(1, 100));

            $tasks->attach($task);

            $manager->persist($task);
        }

        $manager->flush();

        $this->addReference('tasks', $tasks);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}

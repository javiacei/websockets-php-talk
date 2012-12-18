<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    const USERS_NUMBER = 5;

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
        $faker = \Faker\Factory::create();
        $userManager = $this->container->get('fos_user.user_manager');

        for ($i = 1; $i <= self::USERS_NUMBER; $i++) {
            $user = $userManager->createUser();
            $user->setUsername('admin' . $i);
            $user->setEmail($faker->email);
            $user->setPlainPassword('1234');
            $user->setEnabled(true);

            $userManager->updateUser($user);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}

<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use JAL\Bundle\TaskBundle\Entity\State;

class LoadStateData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $stateNames = array('todo', 'doing', 'done');

        $states = new \SplObjectStorage();
        foreach ($stateNames as $name) {
            $state = new State();
            $state->setName($name);
            $states->attach($state);

            $manager->persist($state);
        }

        $manager->flush();

        $this->addReference('states', $states);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}

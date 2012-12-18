<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

namespace JAL\Bundle\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use JAL\Bundle\TaskBundle\Model\UserInterface;

/**
 * JAL\Bundle\TaskBundle\Entity\User
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class User extends BaseUser implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

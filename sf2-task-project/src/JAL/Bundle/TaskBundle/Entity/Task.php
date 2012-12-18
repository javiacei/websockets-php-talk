<?php

namespace JAL\Bundle\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JAL\Bundle\TaskBundle\Model\TaskInterface;

/**
 * JAL\Bundle\TaskBundle\Entity\Task
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="JAL\Bundle\TaskBundle\Entity\TaskRepository")
 */
class Task implements TaskInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="task_user",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id")}
     *      )
     **/
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     **/
    protected $state;

    /**
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     */
    protected $unit;

    /**
     * @ORM\Column(type="integer")
     */
    protected $priority;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add users
     *
     * @param JAL\Bundle\TaskBundle\Entity\User $users
     * @return Task
     */
    public function addUser(\JAL\Bundle\TaskBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param JAL\Bundle\TaskBundle\Entity\User $users
     */
    public function removeUser(\JAL\Bundle\TaskBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set state
     *
     * @param JAL\Bundle\TaskBundle\Entity\State $state
     * @return Task
     */
    public function setState(\JAL\Bundle\TaskBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return JAL\Bundle\TaskBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set unit
     *
     * @param JAL\Bundle\TaskBundle\Entity\Unit $unit
     * @return Task
     */
    public function setUnit(\JAL\Bundle\TaskBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return JAL\Bundle\TaskBundle\Entity\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }
}

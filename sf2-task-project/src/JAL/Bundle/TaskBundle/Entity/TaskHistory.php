<?php

namespace JAL\Bundle\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JAL\Bundle\TaskBundle\Model\TaskHistoryInterface;

/**
 * JAL\Bundle\TaskBundle\Entity\TaskHistory
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class TaskHistory implements TaskHistoryInterface
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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Task", inversedBy="histories")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     **/
    private $task;

    /**
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     **/
    private $state;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     **/
    private $createdAt;

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return TaskHistory
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param JAL\Bundle\TaskBundle\Entity\User $user
     * @return TaskHistory
     */
    public function setUser(\JAL\Bundle\TaskBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return JAL\Bundle\TaskBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set task
     *
     * @param JAL\Bundle\TaskBundle\Entity\Task $task
     * @return TaskHistory
     */
    public function setTask(\JAL\Bundle\TaskBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return JAL\Bundle\TaskBundle\Entity\Task
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set state
     *
     * @param JAL\Bundle\TaskBundle\Entity\State $state
     * @return TaskHistory
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
}

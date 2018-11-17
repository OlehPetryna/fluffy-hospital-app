<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * WorkerWorkingHours
 *
 * @ORM\Table(name="Worker_working_hours", uniqueConstraints={@ORM\UniqueConstraint(name="service_id_from_to", columns={"worker_id", "from", "to", "day"})})
 * @ORM\Entity
 */
class WorkerWorkingHours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="worker_id", type="integer", nullable=false)
     */
    private $workerId;

    /**
     * @var bool
     *
     * @ORM\Column(name="day", type="boolean", nullable=false)
     */
    private $day;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="from", type="time", nullable=false)
     */
    private $from;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="to", type="time", nullable=false)
     */
    private $to;



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set workerId.
     *
     * @param int $workerId
     *
     * @return WorkerWorkingHours
     */
    public function setWorkerId($workerId)
    {
        $this->workerId = $workerId;

        return $this;
    }

    /**
     * Get workerId.
     *
     * @return int
     */
    public function getWorkerId()
    {
        return $this->workerId;
    }

    /**
     * Set day.
     *
     * @param bool $day
     *
     * @return WorkerWorkingHours
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day.
     *
     * @return bool
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set from.
     *
     * @param \DateTime $from
     *
     * @return WorkerWorkingHours
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from.
     *
     * @return \DateTime
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to.
     *
     * @param \DateTime $to
     *
     * @return WorkerWorkingHours
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to.
     *
     * @return \DateTime
     */
    public function getTo()
    {
        return $this->to;
    }
}

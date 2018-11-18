<?php
namespace app\domain;


use Doctrine\ORM\Mapping as ORM;

/**
 * WorkerSpecialWorkingHours
 *
 * @ORM\Table(name="Worker_special_working_hours", uniqueConstraints={@ORM\UniqueConstraint(name="service_id_from_to", columns={"worker_id", "from", "to", "date"})}, indexes={@ORM\Index(name="IDX_915BE11D6B20BA36", columns={"worker_id"})})
 * @ORM\Entity
 */
class WorkerSpecialWorkingHours
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
     * @var bool
     *
     * @ORM\Column(name="is_working", type="boolean", nullable=false)
     */
    private $isWorking = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="from", type="time", nullable=true)
     */
    private $from;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="to", type="time", nullable=true)
     */
    private $to;

    /**
     * @var Worker
     *
     * @ORM\ManyToOne(targetEntity="Worker")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="worker_id", referencedColumnName="id")
     * })
     */
    private $worker;



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
     * Set isWorking.
     *
     * @param bool $isWorking
     *
     * @return WorkerSpecialWorkingHours
     */
    public function setIsWorking($isWorking)
    {
        $this->isWorking = $isWorking;

        return $this;
    }

    /**
     * Get isWorking.
     *
     * @return bool
     */
    public function getIsWorking()
    {
        return $this->isWorking;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return WorkerSpecialWorkingHours
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set from.
     *
     * @param \DateTime|null $from
     *
     * @return WorkerSpecialWorkingHours
     */
    public function setFrom($from = null)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from.
     *
     * @return \DateTime|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to.
     *
     * @param \DateTime|null $to
     *
     * @return WorkerSpecialWorkingHours
     */
    public function setTo($to = null)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to.
     *
     * @return \DateTime|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set worker.
     *
     * @param \Worker|null $worker
     *
     * @return WorkerSpecialWorkingHours
     */
    public function setWorker(\Worker $worker = null)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker.
     *
     * @return \Worker|null
     */
    public function getWorker()
    {
        return $this->worker;
    }
}

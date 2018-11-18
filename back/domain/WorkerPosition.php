<?php
namespace app\domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkerPosition
 *
 * @ORM\Table(name="Worker_position", indexes={@ORM\Index(name="FK_Worker_position_Worker", columns={"worker_id"}), @ORM\Index(name="FK_Worker_position_Position", columns={"position_id"})})
 * @ORM\Entity
 */
class WorkerPosition
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
     * @var Position
     *
     * @ORM\ManyToOne(targetEntity="Position")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * })
     */
    private $position;

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
     * Set position.
     *
     * @param \Position|null $position
     *
     * @return WorkerPosition
     */
    public function setPosition(\Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return Position|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set worker.
     *
     * @param \Worker|null $worker
     *
     * @return WorkerPosition
     */
    public function setWorker(\Worker $worker = null)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker.
     *
     * @return Worker|null
     */
    public function getWorker()
    {
        return $this->worker;
    }
}

<?php
namespace app\domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="Service", indexes={@ORM\Index(name="FK_Service_Worker", columns={"worker_id"})})
 * @ORM\Entity
 */
class Service implements \JsonSerializable
{
    public function __construct()
    {
        $this->workingHours = new ArrayCollection();
    }

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
     * @ORM\Column(name="working_hours_id", type="integer", nullable=false)
     */
    private $workingHoursId;

    /**
     * @var ArrayCollection|WorkerPosition[]
     *
     * @ORM\OneToMany(targetEntity="ServiceWorkingHours", mappedBy="service")
     */
    private $workingHours;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=250, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer", nullable=false)
     */
    private $duration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $creationDate = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdateDate = 'CURRENT_TIMESTAMP';

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
     * Set workingHoursId.
     *
     * @param int $workingHoursId
     *
     * @return Service
     */
    public function setWorkingHoursId($workingHoursId)
    {
        $this->workingHoursId = $workingHoursId;

        return $this;
    }

    /**
     * Get workingHoursId.
     *
     * @return int
     */
    public function getWorkingHoursId()
    {
        return $this->workingHoursId;
    }

    /**
     * @param ArrayCollection|ServiceWorkingHours[]
     * @return $this
     */
    public function setWorkingHours(array $workingHours) {
        $this->workingHours = $workingHours;

        return $this;
    }

    /**
     * @return WorkerPosition[]|ArrayCollection
     */
    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Service
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Service
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set duration.
     *
     * @param int $duration
     *
     * @return Service
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration.
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return Service
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastUpdateDate.
     *
     * @param \DateTime $lastUpdateDate
     *
     * @return Service
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;

        return $this;
    }

    /**
     * Get lastUpdateDate.
     *
     * @return \DateTime
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    /**
     * Set worker.
     *
     * @param Worker|null $worker
     *
     * @return Service
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'title' => $this->getName(),
            'id' => $this->getId(),
            'price' => $this->getPrice(),
            'duration' => $this->getDuration(),
            'worker' => $this->getWorker()->jsonSerialize(),
            'hours' => $this->getWorkingHours()->map(function (ServiceWorkingHours $hours) {
                return $hours->jsonSerialize();
            })->toArray()
        ];
    }
}

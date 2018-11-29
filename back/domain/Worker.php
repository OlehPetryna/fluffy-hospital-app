<?php
namespace app\domain;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Worker
 *
 * @ORM\Table(name="Worker", indexes={@ORM\Index(name="FK_Worker_User", columns={"user_id"}), @ORM\Index(name="FK_Worker_Department", columns={"department_id"})})
 * @ORM\Entity
 */
class Worker implements \JsonSerializable
{
    public function __construct()
    {
        $this->workerPositions = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var Department
     *
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     * })
     */
    private $department;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var ArrayCollection|WorkerPosition[]
     *
     * @ORM\OneToMany(targetEntity="WorkerPosition", mappedBy="worker")
     */
    private $workerPositions;

    /**
     * @var ArrayCollection|WorkerWorkingHours[]
     *
     * @ORM\OneToMany(targetEntity="WorkerWorkingHours", mappedBy="worker")
     */
    private $workingHours;

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
     * Set description.
     *
     * @param string $description
     *
     * @return Worker
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set department.
     *
     * @param Department|null $department
     *
     * @return Worker
     */
    public function setDepartment(\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department.
     *
     * @return Department|null
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set user.
     *
     * @param User|null $user
     *
     * @return Worker
     */
    public function setUser(\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param ArrayCollection $workerPositions
     * @return Worker
     */
    public function setWorkerPositions(ArrayCollection $workerPositions)
    {
        $this->workerPositions = $workerPositions;

        return $this;
    }

    /**
     * @return ArrayCollection|WorkerPosition[]
     */
    public function getWorkerPositions()
    {
        return $this->workerPositions;
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
        return array_replace($this->getUser()->jsonSerialize(), [
            'id' => $this->getId(),
            'description' => $this->getDescription(),
            'positions' => $this->getWorkerPositions()->map(function (WorkerPosition $workerPosition) {
                return $workerPosition->getPosition()->jsonSerialize();
            })->toArray()
        ]);
    }
}

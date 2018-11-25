<?php
namespace app\domain;


use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceWorkingHours
 *
 * @ORM\Table(name="Service_working_hours", uniqueConstraints={@ORM\UniqueConstraint(name="service_id_from_to", columns={"service_id", "from", "to", "day"})}, indexes={@ORM\Index(name="IDX_905B4367ED5CA9E6", columns={"service_id"})})
 * @ORM\Entity
 */
class ServiceWorkingHours implements \JsonSerializable
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
     * @var Service
     *
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="workingHours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * })
     */
    private $service;



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
     * Set day.
     *
     * @param bool $day
     *
     * @return ServiceWorkingHours
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
     * @return ServiceWorkingHours
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
     * @return ServiceWorkingHours
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

    /**
     * Set service.
     *
     * @param Service|null $service
     *
     * @return ServiceWorkingHours
     */
    public function setService(Service$service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service.
     *
     * @return Service|null
     */
    public function getService()
    {
        return $this->service;
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
            'id' => $this->getId(),
            'day' => $this->getDay(),
            'from' => $this->getFrom(),
            'to' => $this->getTo()
        ];
    }
}

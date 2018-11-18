<?php
namespace app\domain;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appointment
 *
 * @ORM\Table(name="Appointment", indexes={@ORM\Index(name="FK_Appointment_Client", columns={"client_id"}), @ORM\Index(name="FK_Appointment_Worker", columns={"worker_id"}), @ORM\Index(name="FK_Appointment_Service", columns={"service_id"}), @ORM\Index(name="FK_Appointment_Service_working_hours", columns={"service_time_id"}), @ORM\Index(name="FK_Appointment_Payment", columns={"payment_id"})})
 * @ORM\Entity
 */
class Appointment
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=0, nullable=false)
     */
    private $status;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var Payment
     *
     * @ORM\ManyToOne(targetEntity="Payment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     * })
     */
    private $payment;

    /**
     * @var Service
     *
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * })
     */
    private $service;

    /**
     * @var ServiceWorkingHours
     *
     * @ORM\ManyToOne(targetEntity="ServiceWorkingHours")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_time_id", referencedColumnName="id")
     * })
     */
    private $serviceTime;

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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Appointment
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
     * Set status.
     *
     * @param string $status
     *
     * @return Appointment
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set client.
     *
     * @param \Client|null $client
     *
     * @return Appointment
     */
    public function setClient(\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set payment.
     *
     * @param \Payment|null $payment
     *
     * @return Appointment
     */
    public function setPayment(\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment.
     *
     * @return Payment|null
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set service.
     *
     * @param \Service|null $service
     *
     * @return Appointment
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
     * Set serviceTime.
     *
     * @param ServiceWorkingHours|null $serviceTime
     *
     * @return Appointment
     */
    public function setServiceTime(ServiceWorkingHours $serviceTime = null)
    {
        $this->serviceTime = $serviceTime;

        return $this;
    }

    /**
     * Get serviceTime.
     *
     * @return ServiceWorkingHours|null
     */
    public function getServiceTime()
    {
        return $this->serviceTime;
    }

    /**
     * Set worker.
     *
     * @param \Worker|null $worker
     *
     * @return Appointment
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

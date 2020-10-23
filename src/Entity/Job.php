<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $positionName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minPayment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxPayment;

    /**
     * @ORM\Column(type="string", length=6000)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $jobAttendanceType;

    /**
     * @ORM\Column(type="integer")
     */
    private $jobEmploymentType;

    /**
     * @ORM\OneToMany(targetEntity=JobResponse::class, mappedBy="job", orphanRemoval=true)
     */
    private $jobResponses;

    /**
     * @ORM\ManyToOne(targetEntity=Organization::class, inversedBy="jobs")
     */
    private $organization;

    public function __construct()
    {
        $this->jobResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositionName(): ?string
    {
        return $this->positionName;
    }

    public function setPositionName(string $positionName): self
    {
        $this->positionName = $positionName;

        return $this;
    }

    public function getMinPayment(): ?int
    {
        return $this->minPayment;
    }

    public function setMinPayment(int $minPayment): self
    {
        $this->minPayment = $minPayment;

        return $this;
    }

    public function getMaxPayment(): ?int
    {
        return $this->maxPayment;
    }

    public function setMaxPayment(?int $maxPayment): self
    {
        $this->maxPayment = $maxPayment;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getJobAttendanceType(): ?int
    {
        return $this->jobAttendanceType;
    }

    public function setJobAttendanceType(int $jobAttendanceЕнType): self
    {
        $this->jobAttendanceType = $jobAttendanceЕнType;

        return $this;
    }

    public function getJobEmploymentType(): ?int
    {
        return $this->jobEmploymentType;
    }

    public function setJobEmploymentType(int $jobEmploymentType): self
    {
        $this->jobEmploymentType = $jobEmploymentType;

        return $this;
    }

    /**
     * @return Collection|JobResponse[]
     */
    public function getJobResponses(): Collection
    {
        return $this->jobResponses;
    }

    public function addJobResponse(JobResponse $jobResponse): self
    {
        if (!$this->jobResponses->contains($jobResponse)) {
            $this->jobResponses[] = $jobResponse;
            $jobResponse->setJob($this);
        }

        return $this;
    }

    public function removeJobResponse(JobResponse $jobResponse): self
    {
        if ($this->jobResponses->removeElement($jobResponse)) {
            // set the owning side to null (unless already changed)
            if ($jobResponse->getJob() === $this) {
                $jobResponse->setJob(null);
            }
        }

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }
}

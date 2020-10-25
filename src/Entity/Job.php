<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={"normalization_context"={"groups"="job:collection:get"}},
 *          "post"
 *     },
 *     itemOperations={
 *          "get"={"normalization_context"={"groups"="job:item:get"}},
 *          "put"
 *     }
 * )
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
{
    public const JOB_ATTENDANCE_OFFICE = 1;
    public const JOB_ATTENDANCE_REMOTE = 2;


    public const JOB_EMPLOYMENT_TYPE_FULL_TIME = 1;
    public const JOB_EMPLOYMENT_TYPE_PART_TIME = 2;

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

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="jobs")
     */
    private $tags;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jobExperience;

    /**
     * @ORM\ManyToMany(targetEntity=JobSkill::class)
     * @JoinTable(name="job_reqiured_skills",
    *      joinColumns={@JoinColumn(name="job_id", referencedColumnName="id")},
    *      inverseJoinColumns={@JoinColumn(name="job_skill_id", referencedColumnName="id")}
    *  )
     */
    private $requiredSkills;

    /**
     * @ORM\ManyToMany(targetEntity=JobSkill::class)
     * @JoinTable(name="job_improved_skills",
     *      joinColumns={@JoinColumn(name="job_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="job_skill_id", referencedColumnName="id")}
     *  )
     */
    private $improvedSkills;


    public function __construct()
    {
        $this->jobResponses = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->requiredSkills = new ArrayCollection();
        $this->improvedSkills = new ArrayCollection();
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read",
     *     "tag:collection:get",
     *     "organization:read"
     * })
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read",
     *     "organization:read"
     * })
     * @return string|null
     */
    public function getPositionName(): ?string
    {
        return $this->positionName;
    }

    public function setPositionName(string $positionName): self
    {
        $this->positionName = $positionName;

        return $this;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read",
     *     "organization:read"
     * })
     * @return int|null
     */
    public function getMinPayment(): ?int
    {
        return $this->minPayment;
    }

    public function setMinPayment(int $minPayment): self
    {
        $this->minPayment = $minPayment;

        return $this;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read",
     *     "organization:read"
     * })
     * @return int|null
     */
    public function getMaxPayment(): ?int
    {
        return $this->maxPayment;
    }

    public function setMaxPayment(?int $maxPayment): self
    {
        $this->maxPayment = $maxPayment;

        return $this;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read",
     *     "organization:read"
     * })
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read",
     *     "organization:read"
     * })
     * @return string|null
     */
    public function getJobAttendanceType(): ?string
    {
        return new JobAttendanceType($this->jobAttendanceType);
    }

    public function setJobAttendanceType(int $jobAttendanceType): self
    {
        $this->jobAttendanceType = $jobAttendanceType;

        return $this;
    }

    /**
     * @Groups({"job:collection:get", "job:item:get"})
     * @return string|null
     */
    public function getJobEmploymentType(): ?string
    {
        return new JobEmploymentType($this->jobEmploymentType);
    }

    public function setJobEmploymentType(int $jobEmploymentType): self
    {
        $this->jobEmploymentType = $jobEmploymentType;

        return $this;
    }

    /**
     * @Groups({
     *     "job:item:get",
     *     "organization:read"
     * })
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

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read"
     * })
     * @return Organization|null
     */
    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @Groups({"job:collection:get", "job:item:get"})
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get"
     * })
     * @return Collection|JobSkill[]
     */
    public function getRequiredSkills(): Collection
    {
        return $this->requiredSkills;
    }

    public function addRequiredSkill(JobSkill $requiredSkill): self
    {
        if (!$this->requiredSkills->contains($requiredSkill)) {
            $this->requiredSkills[] = $requiredSkill;
        }

        return $this;
    }

    public function removeRequiredSkill(JobSkill $requiredSkill): self
    {
        $this->requiredSkills->removeElement($requiredSkill);

        return $this;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get"
     * })
     * @return Collection|JobSkill[]
     */
    public function getImprovedSkills(): Collection
    {
        return $this->improvedSkills;
    }

    public function addImprovedSkill(JobSkill $improvedSkill): self
    {
        if (!$this->improvedSkills->contains($improvedSkill)) {
            $this->improvedSkills[] = $improvedSkill;
        }

        return $this;
    }

    public function removeImprovedSkill(JobSkill $improvedSkill): self
    {
        $this->improvedSkills->removeElement($improvedSkill);

        return $this;
    }

    /**
     * @Groups({
     *     "job:collection:get",
     *     "job:item:get",
     *     "user:read"
     * })
     * @return mixed
     */
    public function getJobExperience()
    {
        return $this->jobExperience;
    }

    /**
     * @param mixed $jobExperience
     */
    public function setJobExperience($jobExperience): void
    {
        $this->jobExperience = $jobExperience;
    }

}

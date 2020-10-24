<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\JobResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=JobResponseRepository::class)
 */
class JobResponse
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_DENY = 2;
    public const STATUS_ACCEPTED = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="jobResponses")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Job::class, inversedBy="jobResponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $job;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $letter;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getLetter(): ?string
    {
        return $this->letter;
    }

    public function setLetter(string $letter): self
    {
        $this->letter = $letter;

        return $this;
    }

    public function getStatus(): ?string
    {
        return new JobResponseStatus($this->status);
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\JobExperienceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=JobExperienceRepository::class)
 */
class JobExperience
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
    private $companyName;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jobTimePeriod;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getJobTimePeriod(): ?string
    {
        return $this->jobTimePeriod;
    }

    public function setJobTimePeriod(string $jobTimePeriod): self
    {
        $this->jobTimePeriod = $jobTimePeriod;

        return $this;
    }
}

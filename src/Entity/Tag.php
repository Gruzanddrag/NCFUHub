<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={"normalization_context"={"groups"="tag:collection:get"}})
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Job::class, mappedBy="tags")
     */
    private $jobs;

    /**
     * @ORM\ManyToMany(targetEntity=Internship::class, mappedBy="tags")
     */
    private $internships;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->internships = new ArrayCollection();
    }

    /**
     * @Groups({
     *     "tag:collection:get",
     *     "job:item:get",
     *     "internship:item:get"
     * })
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({
     *     "tag:collection:get",
     *     "job:item:get",
     *     "internship:item:get"
     * })
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @Groups({
     *     "tag:collection:get"
     * })
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->addTag($this);
        }

        return $this;
    }

    public function removeJob(Job $job): self
    {
        if ($this->jobs->removeElement($job)) {
            $job->removeTag($this);
        }

        return $this;
    }

    /**
     * @Groups({
     *     "tag:collection:get",
     * })
     * @return Collection|Internship[]
     */
    public function getInternships(): Collection
    {
        return $this->internships;
    }

    public function addInternship(Internship $internship): self
    {
        if (!$this->internships->contains($internship)) {
            $this->internships[] = $internship;
            $internship->addTag($this);
        }

        return $this;
    }

    public function removeInternship(Internship $internship): self
    {
        if ($this->internships->removeElement($internship)) {
            $internship->removeTag($this);
        }

        return $this;
    }
}

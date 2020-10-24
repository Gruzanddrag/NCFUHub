<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InternshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={"normalization_context"={"groups"="internship:collection:get"}},
 *          "post"
 *     },
 *     itemOperations={
 *          "get"={"normalization_context"={"groups"="internship:item:get"}},
 *          "put"
 *     }
 * )
 * @ORM\Entity(repositoryClass=InternshipRepository::class)
 */
class Internship
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Organization::class, inversedBy="internships")
     */
    private $organization;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="internships")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=JobSkill::class, inversedBy="internships")
     */
    private $requiredSkills;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->requiredSkills = new ArrayCollection();
    }

    /**
     * @Groups({"internship:collection:get", "internship:item:get"})
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"internship:collection:get", "internship:item:get"})
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
     * @Groups({"internship:collection:get", "internship:item:get"})
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
     * @Groups({"internship:collection:get", "internship:item:get"})
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
     * @Groups({"internship:collection:get", "internship:item:get"})
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
     * @Groups({"internship:collection:get", "internship:item:get"})
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
}

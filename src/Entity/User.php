<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thirdname;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity=UserProfile::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userProfile;

    /**
     * @ORM\OneToMany(targetEntity=JobResponse::class, mappedBy="user")
     */
    private $jobResponses;

    public function __construct()
    {
        $this->jobResponses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getThirdname(): ?string
    {
        return $this->thirdname;
    }

    public function setThirdname(string $thirdname): self
    {
        $this->thirdname = $thirdname;

        return $this;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(?UserProfile $userProfile): self
    {
        $this->userProfile = $userProfile;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $userProfile ? null : $this;
        if ($userProfile->getUser() !== $newUser) {
            $userProfile->setUser($newUser);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
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
            $jobResponse->setUser($this);
        }

        return $this;
    }

    public function removeJobResponse(JobResponse $jobResponse): self
    {
        if ($this->jobResponses->removeElement($jobResponse)) {
            // set the owning side to null (unless already changed)
            if ($jobResponse->getUser() === $this) {
                $jobResponse->setUser(null);
            }
        }

        return $this;
    }
}

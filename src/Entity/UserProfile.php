<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserProfileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserProfileRepository::class)
 */
class UserProfile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userProfile", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=6000)
     */
    private $aboutMe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $haveJobPermission;

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

    public function getAboutMe(): ?string
    {
        return $this->aboutMe;
    }

    public function setAboutMe(string $aboutMe): self
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    public function getHaveJobPermission(): ?bool
    {
        return $this->haveJobPermission;
    }

    public function setHaveJobPermission(bool $haveJobPermission): self
    {
        $this->haveJobPermission = $haveJobPermission;

        return $this;
    }
}

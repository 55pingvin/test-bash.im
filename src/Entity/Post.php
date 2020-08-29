<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{

    public const NUMBER_OF_ITEMS = 10;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     */
    private $created_by;

    /**
     * @ORM\OneToMany(targetEntity=Complaint::class, mappedBy="post")
     */
    private $complaints;

    /**
     * @ORM\OneToMany(targetEntity=PostRate::class, mappedBy="post")
     */
    private $rates;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $ipv4;

    /**
     * @ORM\Column(type="integer")
     */
    private $rate;

    public function __construct()
    {
        $this->complaints = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->created_at = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return Collection|PostRate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    /**
     * @return Collection|Complaint[]
     */
    public function getComplaints(): Collection
    {
        return $this->complaints;
    }

    public function addComplaint(Complaint $complaint): self
    {
        if (!$this->complaints->contains($complaint)) {
            $this->complaints[] = $complaint;
            $complaint->setPost($this);
        }

        return $this;
    }

    public function removeComplaint(Complaint $complaint): self
    {
        if ($this->complaints->contains($complaint)) {
            $this->complaints->removeElement($complaint);
            // set the owning side to null (unless already changed)
            if ($complaint->getPost() === $this) {
                $complaint->setPost(null);
            }
        }

        return $this;
    }

    public function getIpv4(): ?string
    {
        return $this->ipv4;
    }

    public function setIpv4(string $ipv4): self
    {
        $this->ipv4 = $ipv4;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate += $rate;

        return $this;
    }

}

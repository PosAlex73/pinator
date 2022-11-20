<?php

namespace App\Entity;

use App\Repository\ThreadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThreadRepository::class)]
class Thread
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'thread', cascade: ['persist', 'remove'])]
    private ?User $tuser = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedTime = null;

    #[ORM\Column(length: 1)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'thread', targetEntity: ThreadMessage::class)]
    private Collection $threadMessages;

    public function __construct()
    {
        $this->threadMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTuser(): ?User
    {
        return $this->tuser;
    }

    public function setTuser(?User $tuser): self
    {
        $this->tuser = $tuser;

        return $this;
    }

    public function getCreatedTime(): ?\DateTimeInterface
    {
        return $this->createdTime;
    }

    public function setCreatedTime(\DateTimeInterface $createdTime): self
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    public function getUpdatedTime(): ?\DateTimeInterface
    {
        return $this->updatedTime;
    }

    public function setUpdatedTime(\DateTimeInterface $updatedTime): self
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, ThreadMessage>
     */
    public function getThreadMessages(): Collection
    {
        return $this->threadMessages;
    }

    public function addThreadMessage(ThreadMessage $threadMessage): self
    {
        if (!$this->threadMessages->contains($threadMessage)) {
            $this->threadMessages->add($threadMessage);
            $threadMessage->setThread($this);
        }

        return $this;
    }

    public function removeThreadMessage(ThreadMessage $threadMessage): self
    {
        if ($this->threadMessages->removeElement($threadMessage)) {
            // set the owning side to null (unless already changed)
            if ($threadMessage->getThread() === $this) {
                $threadMessage->setThread(null);
            }
        }

        return $this;
    }
}

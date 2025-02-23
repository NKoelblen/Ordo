<?php

namespace App\Entity;

use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\Table(name: '`member`')]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Space>
     */
    #[ORM\ManyToMany(targetEntity: Space::class, inversedBy: 'members')]
    private Collection $spaces;

    /**
     * @var Collection<int, TransactionDetail>
     */
    #[ORM\OneToMany(targetEntity: TransactionDetail::class, mappedBy: 'groupMember')]
    private Collection $transactionDetails;

    /**
     * @var Collection<int, Budget>
     */
    #[ORM\OneToMany(targetEntity: Budget::class, mappedBy: 'groupMember')]
    private Collection $budgets;

    public function __construct()
    {
        $this->spaces = new ArrayCollection();
        $this->transactionDetails = new ArrayCollection();
        $this->budgets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Space>
     */
    public function getSpaces(): Collection
    {
        return $this->spaces;
    }

    public function addSpace(Space $space): static
    {
        if (!$this->spaces->contains($space)) {
            $this->spaces->add($space);
        }

        return $this;
    }

    public function removeSpace(Space $space): static
    {
        $this->spaces->removeElement($space);

        return $this;
    }

    /**
     * @return Collection<int, TransactionDetail>
     */
    public function getTransactionDetails(): Collection
    {
        return $this->transactionDetails;
    }

    public function addTransactionDetail(TransactionDetail $transactionDetail): static
    {
        if (!$this->transactionDetails->contains($transactionDetail)) {
            $this->transactionDetails->add($transactionDetail);
            $transactionDetail->setGroupMember($this);
        }

        return $this;
    }

    public function removeTransactionDetail(TransactionDetail $transactionDetail): static
    {
        if ($this->transactionDetails->removeElement($transactionDetail)) {
            // set the owning side to null (unless already changed)
            if ($transactionDetail->getGroupMember() === $this) {
                $transactionDetail->setGroupMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Budget>
     */
    public function getBudgets(): Collection
    {
        return $this->budgets;
    }

    public function addBudget(Budget $budget): static
    {
        if (!$this->budgets->contains($budget)) {
            $this->budgets->add($budget);
            $budget->setGroupMember($this);
        }

        return $this;
    }

    public function removeBudget(Budget $budget): static
    {
        if ($this->budgets->removeElement($budget)) {
            // set the owning side to null (unless already changed)
            if ($budget->getGroupMember() === $this) {
                $budget->setGroupMember(null);
            }
        }

        return $this;
    }
}

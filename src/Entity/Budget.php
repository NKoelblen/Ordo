<?php

namespace App\Entity;

use App\Attribute\Displayable;
use App\Repository\BudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'budgets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Displayable]
    private ?string $amount = null;

    /**
     * @var Collection<int, Space>
     */
    #[ORM\ManyToMany(targetEntity: Space::class, inversedBy: 'budgets')]
    #[Displayable]
    private Collection $spaces;

    #[ORM\Column]
    #[Displayable]
    private ?int $month = null;

    #[ORM\Column]
    #[Displayable]
    private ?int $year = null;

    #[ORM\ManyToOne(inversedBy: 'budgets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Displayable]
    private ?Member $groupMember = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(options: ['default' => false])]
    #[Displayable]
    private bool $recurrent = false;

    #[ORM\Column(nullable: true)]
    #[Displayable]
    private ?int $endMonth = null;

    #[ORM\Column(nullable: true)]
    #[Displayable]
    private ?int $endYear = null;

    /**
     * @var Collection<int, BudgetException>
     */
    #[ORM\OneToMany(targetEntity: BudgetException::class, mappedBy: 'budget')]
    private Collection $budgetExceptions;

    public function __construct()
    {
        $this->spaces = new ArrayCollection();
        $this->budgetExceptions = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

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

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getGroupMember(): ?Member
    {
        return $this->groupMember;
    }

    public function setGroupMember(?Member $groupMember): static
    {
        $this->groupMember = $groupMember;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isRecurrent(): ?bool
    {
        return $this->recurrent;
    }

    public function setRecurrent(bool $recurrent): static
    {
        $this->recurrent = $recurrent;

        return $this;
    }

    public function getEndMonth(): ?int
    {
        return $this->endMonth;
    }

    public function setEndMonth(?int $endMonth): static
    {
        $this->endMonth = $endMonth;

        return $this;
    }

    public function getEndYear(): ?int
    {
        return $this->endYear;
    }

    public function setEndYear(?int $endYear): static
    {
        $this->endYear = $endYear;

        return $this;
    }

    /**
     * @return Collection<int, BudgetExceptions>
     */
    public function getBudgetExceptions(): Collection
    {
        return $this->budgetExceptions;
    }

    public function addBudgetException(BudgetExceptions $budgetException): static
    {
        if (!$this->budgetExceptions->contains($budgetException)) {
            $this->budgetExceptions->add($budgetException);
            $budgetException->setBudget($this);
        }

        return $this;
    }

    public function removeBudgetException(BudgetExceptions $budgetException): static
    {
        if ($this->budgetExceptions->removeElement($budgetException)) {
            // set the owning side to null (unless already changed)
            if ($budgetException->getBudget() === $this) {
                $budgetException->setBudget(null);
            }
        }

        return $this;
    }
}

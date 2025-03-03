<?php

namespace App\Entity;

use App\Attribute\Displayable;
use App\Repository\SpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpaceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Space
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Displayable]
    private ?string $name = null;

    #[ORM\Column(options: ['default' => false])]
    #[Displayable]
    private ?bool $professional = false;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[Displayable]
    private ?self $parent = null;

    private ?int $level = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $children;

    /**
     * @var Collection<int, Account>
     */
    #[ORM\ManyToMany(targetEntity: Account::class, mappedBy: 'spaces')]
    private Collection $accounts;

    /**
     * @var Collection<int, Budget>
     */
    #[ORM\ManyToMany(targetEntity: Budget::class, mappedBy: 'spaces')]
    private Collection $budgets;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'spaces')]
    private Collection $categories;

    /**
     * @var Collection<int, Counterparty>
     */
    #[ORM\ManyToMany(targetEntity: Counterparty::class, mappedBy: 'spaces')]
    private Collection $counterparties;

    /**
     * @var Collection<int, Transaction>
     */
    #[ORM\ManyToMany(targetEntity: Transaction::class, mappedBy: 'spaces')]
    private Collection $transactions;

    /**
     * @var Collection<int, Member>
     */
    #[ORM\ManyToMany(targetEntity: Member::class, mappedBy: 'spaces')]
    private Collection $members;

    #[ORM\Column(length: 255, options: ['default' => 'open'])]
    #[Displayable]
    private ?string $status = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->accounts = new ArrayCollection();
        $this->budgets = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->counterparties = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->members = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function isProfessional(): ?bool
    {
        return $this->professional;
    }

    public function setProfessional(bool $professional): static
    {
        $this->professional = $professional;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): static
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts->add($account);
            $account->addSpace($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): static
    {
        if ($this->accounts->removeElement($account)) {
            $account->removeSpace($this);
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
            $budget->addSpace($this);
        }

        return $this;
    }

    public function removeBudget(Budget $budget): static
    {
        if ($this->budgets->removeElement($budget)) {
            $budget->removeSpace($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addSpace($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeSpace($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Counterparty>
     */
    public function getCounterparties(): Collection
    {
        return $this->counterparties;
    }

    public function addCounterparty(Counterparty $counterparty): static
    {
        if (!$this->counterparties->contains($counterparty)) {
            $this->counterparties->add($counterparty);
            $counterparty->addSpace($this);
        }

        return $this;
    }

    public function removeCounterparty(Counterparty $counterparty): static
    {
        if ($this->counterparties->removeElement($counterparty)) {
            $counterparty->removeSpace($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
            $transaction->addSpace($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            $transaction->removeSpace($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addSpace($this);
        }

        return $this;
    }

    public function removeMember(Member $member): static
    {
        if ($this->members->removeElement($member)) {
            $member->removeSpace($this);
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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
}

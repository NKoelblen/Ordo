<?php

namespace App\Entity;

use App\Attribute\Displayable;
use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Displayable]
    private ?Account $account = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Displayable]
    private ?string $debit = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Displayable]
    private ?string $credit = null;

    #[ORM\Column(length: 255)]
    #[Displayable]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Displayable]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Displayable]
    private ?\DateTimeInterface $operationDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Displayable]
    private ?\DateTimeInterface $emissionDate = null;

    /**
     * @var Collection<int, Space>
     */
    #[ORM\ManyToMany(targetEntity: Space::class, inversedBy: 'transactions')]
    #[Displayable]
    private Collection $spaces;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Displayable]
    private ?Counterparty $counterparty = null;

    /**
     * @var Collection<int, Detail>
     */
    #[ORM\OneToMany(targetEntity: Detail::class, mappedBy: 'transaction')]
    private Collection $details;

    public function __construct()
    {
        $this->spaces = new ArrayCollection();
        $this->details = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): static
    {
        $this->account = $account;

        return $this;
    }

    public function getDebit(): ?string
    {
        return $this->debit;
    }

    public function setDebit(?string $debit): static
    {
        $this->debit = $debit;

        return $this;
    }

    public function getCredit(): ?string
    {
        return $this->credit;
    }

    public function setCredit(string $credit): static
    {
        $this->credit = $credit;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getOperationDate(): ?\DateTimeInterface
    {
        return $this->operationDate;
    }

    public function setOperationDate(\DateTimeInterface $operationDate): static
    {
        $this->operationDate = $operationDate;

        return $this;
    }

    public function getEmissionDate(): ?\DateTimeInterface
    {
        return $this->emissionDate;
    }

    public function setEmissionDate(\DateTimeInterface $emissionDate): static
    {
        $this->emissionDate = $emissionDate;

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

    public function getCounterparty(): ?Counterparty
    {
        return $this->counterparty;
    }

    public function setCounterparty(?Counterparty $counterparty): static
    {
        $this->counterparty = $counterparty;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setTransaction($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getTransaction() === $this) {
                $detail->setTransaction(null);
            }
        }

        return $this;
    }
}

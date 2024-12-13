<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Expenses>
     */
    #[ORM\OneToMany(targetEntity: Expenses::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $Expenses;

    public function __construct()
    {
        $this->Expenses = new ArrayCollection();
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
     * @return Collection<int, Expenses>
     */
    public function getExpenses(): Collection
    {
        return $this->Expenses;
    }

    public function addExpense(Expenses $expense): static
    {
        if (!$this->Expenses->contains($expense)) {
            $this->Expenses->add($expense);
            $expense->setCategory($this);
        }

        return $this;
    }

    public function removeExpense(Expenses $expense): static
    {
        if ($this->Expenses->removeElement($expense)) {
            // set the owning side to null (unless already changed)
            if ($expense->getCategory() === $this) {
                $expense->setCategory(null);
            }
        }

        return $this;
    }
}

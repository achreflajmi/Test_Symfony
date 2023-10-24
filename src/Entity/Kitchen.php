<?php

namespace App\Entity;

use App\Repository\KitchenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KitchenRepository::class)]
class Kitchen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $staff_nbr = null;

    #[ORM\OneToMany(mappedBy: 'Kitchen', targetEntity: Cook::class, orphanRemoval: true)]
    private Collection $cooks;

    public function __construct()
    {
        $this->cooks = new ArrayCollection();
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

    public function getStaffNbr(): ?int
    {
        return $this->staff_nbr;
    }

    public function setStaffNbr(int $staff_nbr): static
    {
        $this->staff_nbr = $staff_nbr;

        return $this;
    }

    /**
     * @return Collection<int, Cook>
     */
    public function getCooks(): Collection
    {
        return $this->cooks;
    }

    public function addCook(Cook $cook): static
    {
        if (!$this->cooks->contains($cook)) {
            $this->cooks->add($cook);
            $cook->setKitchen($this);
        }

        return $this;
    }

    public function removeCook(Cook $cook): static
    {
        if ($this->cooks->removeElement($cook)) {
            // set the owning side to null (unless already changed)
            if ($cook->getKitchen() === $this) {
                $cook->setKitchen(null);
            }
        }

        return $this;
    }
}

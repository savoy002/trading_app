<?php

namespace App\Entity;

use App\Entity\TypeDate;
use App\Repository\DateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DateRepository::class)]
#[ORM\Table(name: 'DATE_INFO')]
class Date
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_date')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, name: 'val_date')]
    private ?\DateTime $valeur = null;

    #[ORM\Column(type: Types::STRING, length: 255, name: 'type_date')]
    private ?TypeDate $type = null;

    /**
     * @var Collection<int, Valeur>
     */
    #[ORM\OneToMany(targetEntity: Valeur::class, mappedBy: 'date', orphanRemoval: true)]
    private Collection $Valeur;

    public function __construct()
    {
        $this->Valeur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeur(): ?\DateTime
    {
        return $this->valeur;
    }

    public function setValeur(\DateTime $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getType(): ?TypeDate
    {
        return $this->type;
    }

    public function setType(TypeDate $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function addValeur(Valeur $valeur): static
    {
        if (!$this->Valeur->contains($valeur)) {
            $this->Valeur->add($valeur);
            $valeur->setDate($this);
        }

        return $this;
    }

    public function removeValeur(Valeur $valeur): static
    {
        if ($this->Valeur->removeElement($valeur)) {
            // set the owning side to null (unless already changed)
            if ($valeur->getDate() === $this) {
                $valeur->setDate(null);
            }
        }

        return $this;
    }
}

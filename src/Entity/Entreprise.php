<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[ORM\Table(name: 'ENTREPRISE')]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_ent')]
    private ?int $id = null;

    #[ORM\Column(length: 255, name: 'nom_ent')]
    private ?string $nom = null;

    #[ORM\Column(length: 10, name: 'sym_ent')]
    private ?string $symbole = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, name: 'inf_ent')]
    private ?string $information = null;

    /**
     * @var Collection<int, Valeur>
     */
    #[ORM\OneToMany(targetEntity: Valeur::class, mappedBy: 'entreprise', orphanRemoval: true)]
    private Collection $valeurs;

    public function __construct()
    {
        $this->valeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSymbole(): ?string
    {
        return $this->symbole;
    }

    public function setSymbole(string $symbole): static
    {
        $this->symbole = $symbole;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): static
    {
        $this->information = $information;

        return $this;
    }

    /**
     * @return Collection<int, Valeur>
     */
    public function getValeurs(): Collection
    {
        return $this->valeurs;
    }

    public function addValeur(Valeur $valeur): static
    {
        if (!$this->valeurs->contains($valeur)) {
            $this->valeurs->add($valeur);
            $valeur->setEntreprise($this);
        }

        return $this;
    }

    public function removeValeur(Valeur $valeur): static
    {
        if ($this->valeurs->removeElement($valeur)) {
            // set the owning side to null (unless already changed)
            if ($valeur->getEntreprise() === $this) {
                $valeur->setEntreprise(null);
            }
        }

        return $this;
    }
}

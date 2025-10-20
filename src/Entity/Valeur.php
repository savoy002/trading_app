<?php

namespace App\Entity;

use App\Repository\ValeurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValeurRepository::class)]
#[ORM\Table(name: 'VALEUR')]
class Valeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_val')]
    private ?int $id = null;

    #[ORM\Column(name: 'ouv_val')]
    private ?int $ouverture = null;

    #[ORM\Column(name: 'hau_val')]
    private ?int $haute = null;

    #[ORM\Column(name: 'bas_val')]
    private ?int $basse = null;

    #[ORM\Column(name: 'fer_val')]
    private ?int $fermeture = null;

    #[ORM\Column(name: 'vol_val')]
    private ?int $volume = null;

    #[ORM\ManyToOne(inversedBy: 'valeurs')]
    #[ORM\JoinColumn(name: 'id_ent', nullable: false)]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne(inversedBy: 'Valeur')]
    #[ORM\JoinColumn(name: 'id_date', nullable: false)]
    private ?Date $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOuverture(): ?int
    {
        return $this->ouverture;
    }

    public function setOuverture(int $ouverture): static
    {
        $this->ouverture = $ouverture;

        return $this;
    }

    public function getHaute(): ?int
    {
        return $this->haute;
    }

    public function setHaute(int $haute): static
    {
        $this->haute = $haute;

        return $this;
    }

    public function getBasse(): ?int
    {
        return $this->basse;
    }

    public function setBasse(int $basse): static
    {
        $this->basse = $basse;

        return $this;
    }

    public function getFermeture(): ?int
    {
        return $this->fermeture;
    }

    public function setFermeture(int $fermeture): static
    {
        $this->fermeture = $fermeture;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getDate(): ?Date
    {
        return $this->date;
    }

    public function setDate(?Date $date): static
    {
        $this->date = $date;

        return $this;
    }
}

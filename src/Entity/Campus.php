<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\OneToMany(targetEntity: Participant::class, mappedBy: 'campus')]
    private Collection $participantRattaches;

    /**
     * @var Collection<int, Sortie>
     */
    #[ORM\OneToMany(targetEntity: Sortie::class, mappedBy: 'campusOrganisateur')]
    private Collection $sorties;

    public function __construct()
    {
        $this->participantRattaches = new ArrayCollection();
        $this->sorties = new ArrayCollection();
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

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipantRattaches(): Collection
    {
        return $this->participantRattaches;
    }

    public function addParticipantRattach(Participant $participantRattach): static
    {
        if (!$this->participantRattaches->contains($participantRattach)) {
            $this->participantRattaches->add($participantRattach);
            $participantRattach->setCampus($this);
        }

        return $this;
    }

    public function removeParticipantRattach(Participant $participantRattach): static
    {
        if ($this->participantRattaches->removeElement($participantRattach)) {
            // set the owning side to null (unless already changed)
            if ($participantRattach->getCampus() === $this) {
                $participantRattach->setCampus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): static
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->setCampusOrganisateur($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): static
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getCampusOrganisateur() === $this) {
                $sorty->setCampusOrganisateur(null);
            }
        }

        return $this;
    }
}

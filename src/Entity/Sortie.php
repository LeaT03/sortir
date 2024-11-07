<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message:'Entrez un nom.')]
    #[Assert\Length(max: 50, maxMessage: "{{ limit }} caractères maximums autorisés.")]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'Entrez une date et un horaire.')]
    #[Assert\GreaterThan("today", message: 'La date doit être ultérieure à la date du jour.')]
    private ?\DateTimeImmutable $dateHeureDebut = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'Entrez une durée.')]
    #[Assert\Positive(message: 'La durée doit être positive.')]
    private ?int $duree = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'Entrez une date.')]
    #[Assert\LessThan(propertyPath: "dateHeureDebut")]
    private ?\DateTimeImmutable $dateLimiteInscription = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'Entrez un nombre maximum de participants.')]
    #[Assert\Positive(message: 'Le nombre doit être positif.')]
    private ?int $nbInscriptionMax = null;

    #[ORM\Column(length: 300, nullable: true)]
    #[Assert\Length(max: 300, maxMessage: "{{ limit }} caractères maximums autorisés.")]
    private ?string $infosSortie = null;

    /**
     * @var Collection<int, Participant>
     */
    #[ORM\ManyToMany(targetEntity: Participant::class, mappedBy: 'sorties')]
    private Collection $participantInscrits;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campusOrganisateur = null;

    #[ORM\ManyToOne(inversedBy: 'sortieOrganisees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Participant $participantOrganisateur = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $lieu = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    public function __construct()
    {
        $this->participantInscrits = new ArrayCollection();
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

    public function getDateHeureDebut(): ?\DateTimeImmutable
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(?\DateTimeImmutable $dateHeureDebut): static
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeImmutable
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(?\DateTimeImmutable $dateLimiteInscription): static
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionMax(): ?int
    {
        return $this->nbInscriptionMax;
    }

    public function setNbInscriptionMax(?int $nbInscriptionMax): static
    {
        $this->nbInscriptionMax = $nbInscriptionMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): static
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipantInscrits(): Collection
    {
        return $this->participantInscrits;
    }

    public function addParticipantInscrit(Participant $participantInscrit): static
    {
        if (!$this->participantInscrits->contains($participantInscrit)) {
            $this->participantInscrits->add($participantInscrit);
            $participantInscrit->addSorty($this);
        }

        return $this;
    }

    public function removeParticipantInscrit(Participant $participantInscrit): static
    {
        if ($this->participantInscrits->removeElement($participantInscrit)) {
            $participantInscrit->removeSorty($this);
        }

        return $this;
    }

    public function getCampusOrganisateur(): ?Campus
    {
        return $this->campusOrganisateur;
    }

    public function setCampusOrganisateur(?Campus $campusOrganisateur): static
    {
        $this->campusOrganisateur = $campusOrganisateur;

        return $this;
    }

    public function getParticipantOrganisateur(): ?Participant
    {
        return $this->participantOrganisateur;
    }

    public function setParticipantOrganisateur(?Participant $participantOrganisateur): static
    {
        $this->participantOrganisateur = $participantOrganisateur;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }
}

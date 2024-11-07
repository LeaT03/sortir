<?php

namespace App\Form\Models;

use App\Entity\Campus;
use phpDocumentor\Reflection\Types\Boolean;

class Search
{
    private ?Campus $campusOrganisateur = null;
    private string $recherche;
    private \DateTimeImmutable $dateEntre;
    private \DateTimeImmutable $dateFin;

    private Boolean $sortieOrganisateur;
    private Boolean $sortieInscrit;
    private Boolean $sortieNonInscrit;
    private Boolean $sortiePassee;

    public function getCampusOrganisateur(): ?Campus
    {
        return $this->campusOrganisateur;
    }

    public function setCampusOrganisateur(?Campus $campusOrganisateur): Search
    {
        $this->campusOrganisateur = $campusOrganisateur;
        return $this;
    }



    public function isSortiePassee(): bool
    {
        return $this->sortiePassee;
    }

    public function setSortiePassee(bool $sortiePassee): Search
    {
        $this->sortiePassee = $sortiePassee;
        return $this;
    }

    public function isSortieNonInscrit(): bool
    {
        return $this->sortieNonInscrit;
    }

    public function setSortieNonInscrit(bool $sortieNonInscrit): Search
    {
        $this->sortieNonInscrit = $sortieNonInscrit;
        return $this;
    }

    public function isSortieInscrit(): bool
    {
        return $this->sortieInscrit;
    }

    public function setSortieInscrit(bool $sortieInscrit): Search
    {
        $this->sortieInscrit = $sortieInscrit;
        return $this;
    }

    public function isSortieOrganisateur(): bool
    {
        return $this->sortieOrganisateur;
    }

    public function setSortieOrganisateur(bool $sortieOrganisateur): Search
    {
        $this->sortieOrganisateur = $sortieOrganisateur;
        return $this;
    }

    public function getDateFin(): \DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeImmutable $dateFin): Search
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getDateEntre(): \DateTimeImmutable
    {
        return $this->dateEntre;
    }

    public function setDateEntre(\DateTimeImmutable $dateEntre): Search
    {
        $this->dateEntre = $dateEntre;
        return $this;
    }

    public function getRecherche(): string
    {
        return $this->recherche;
    }

    public function setRecherche(string $recherche): Search
    {
        $this->recherche = $recherche;
        return $this;
    }




}
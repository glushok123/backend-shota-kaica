<?php

namespace App\Entity;

use App\Repository\DocumetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumetRepository::class)]
class Documet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fond = null;

    #[ORM\Column(length: 255)]
    private ?string $opis = null;

    #[ORM\Column(length: 255)]
    private ?string $numberCase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numberList = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $anatation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $geography = null;

    #[ORM\ManyToOne(inversedBy: 'documets1')]
    private ?Ekdi $ekdi1 = null;

    #[ORM\ManyToOne(inversedBy: 'documets2')]
    private ?Ekdi $ekdi2 = null;

    #[ORM\ManyToOne(inversedBy: 'document3')]
    private ?Ekdi $ekdi3 = null;

    #[ORM\ManyToOne(inversedBy: 'documents4')]
    private ?Ekdi $ekdi4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userGroup = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deadlineDates = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $yearStart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $yearEnd = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $nameCase = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFond(): ?string
    {
        return $this->fond;
    }

    public function setFond(?string $fond): static
    {
        $this->fond = $fond;

        return $this;
    }

    public function getOpis(): ?string
    {
        return $this->opis;
    }

    public function setOpis(string $opis): static
    {
        $this->opis = $opis;

        return $this;
    }

    public function getNumberCase(): ?string
    {
        return $this->numberCase;
    }

    public function setNumberCase(string $numberCase): static
    {
        $this->numberCase = $numberCase;

        return $this;
    }

    public function getNumberList(): ?string
    {
        return $this->numberList;
    }

    public function setNumberList(string $numberList): static
    {
        $this->numberList = $numberList;

        return $this;
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

    public function getAnatation(): ?string
    {
        return $this->anatation;
    }

    public function setAnatation(string $anatation): static
    {
        $this->anatation = $anatation;

        return $this;
    }

    public function getGeography(): ?string
    {
        return $this->geography;
    }

    public function setGeography(string $geography): static
    {
        $this->geography = $geography;

        return $this;
    }

    public function getEkdi1(): ?Ekdi
    {
        return $this->ekdi1;
    }

    public function setEkdi1(?Ekdi $ekdi1): static
    {
        $this->ekdi1 = $ekdi1;

        return $this;
    }

    public function getEkdi2(): ?Ekdi
    {
        return $this->ekdi2;
    }

    public function setEkdi2(?Ekdi $ekdi2): static
    {
        $this->ekdi2 = $ekdi2;

        return $this;
    }

    public function getEkdi3(): ?Ekdi
    {
        return $this->ekdi3;
    }

    public function setEkdi3(?Ekdi $ekdi3): static
    {
        $this->ekdi3 = $ekdi3;

        return $this;
    }

    public function getEkdi4(): ?Ekdi
    {
        return $this->ekdi4;
    }

    public function setEkdi4(?Ekdi $ekdi4): static
    {
        $this->ekdi4 = $ekdi4;

        return $this;
    }

    public function getNameFile(): ?string
    {
        return $this->nameFile;
    }

    public function setNameFile(string $nameFile): static
    {
        $this->nameFile = $nameFile;

        return $this;
    }

    public function getUserGroup(): ?string
    {
        return $this->userGroup;
    }

    public function setUserGroup(string $userGroup): static
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    public function getDeadlineDates(): ?string
    {
        return $this->deadlineDates;
    }

    public function setDeadlineDates(string $deadlineDates): static
    {
        $this->deadlineDates = $deadlineDates;

        return $this;
    }

    public function getYearStart(): ?string
    {
        return $this->yearStart;
    }

    public function setYearStart(?string $yearStart): static
    {
        $this->yearStart = $yearStart;

        return $this;
    }

    public function getYearEnd(): ?string
    {
        return $this->yearEnd;
    }

    public function setYearEnd(?string $yearEnd): static
    {
        $this->yearEnd = $yearEnd;

        return $this;
    }

    public function getNameCase(): ?string
    {
        return $this->nameCase;
    }

    public function setNameCase(string $nameCase): static
    {
        $this->nameCase = $nameCase;

        return $this;
    }
}

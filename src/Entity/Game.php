<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name:'game')]
#[ORM\Entity]
class Game
{
    use TimestampableEntity;

    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\Length(max: 100)]
    #[ORM\Column(length: 100, nullable: false)]
    private string $name = '';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?DateTime $finishedAt = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?int $finishedTimes = null;

    #[ORM\Column(nullable:false, options: ['default' => false])]
    private bool $isSearched = false;

    #[ORM\Column(nullable:false, options: ['default' => false])]
    private bool $isGameOfTheYear = false;

    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Platform::class)]
    #[ORM\JoinColumn(nullable:false)]
    private Platform $platform;


    public function __toString()
    {
        return sprintf('%s [%s]', $this->name, $this->id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): void
    {
        $this->picture = $picture;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): void
    {
        $this->cover = $cover;
    }


    public function getFinishedAt(): ?DateTime
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?DateTime $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    public function getFinishedTimes(): ?int
    {
        return $this->finishedTimes;
    }

    public function setFinishedTimes(?int $finishedTimes): void
    {
        $this->finishedTimes = $finishedTimes;
    }

    public function getIsSearched(): bool
    {
        return $this->isSearched;
    }

    public function setIsSearched(bool $isSearched): void
    {
        $this->isSearched = $isSearched;
    }

    public function getIsGameOfTheYear(): bool
    {
        return $this->isGameOfTheYear;
    }

    public function setIsGameOfTheYear(bool $isGameOfTheYear): void
    {
        $this->isGameOfTheYear = $isGameOfTheYear;
    }

    public function getPlatform(): Platform
    {
        return $this->platform;
    }

    public function setPlatform(Platform $platform): void
    {
        $this->platform = $platform;
    }
}

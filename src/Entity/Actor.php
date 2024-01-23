<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
#[ApiResource(paginationType: 'page')]
#[ApiFilter(SearchFilter::class, properties: ['lastname'=>'partial', 'firstname'=>'partial'])]
#[ApiFilter(DateFilter::class, properties: ['dob'])]
#[ApiFilter(OrderFilter::class, properties: ['lastname'=>'ASC'])]
class Actor
{
    public const HEY = ['Oscar', 'Grammy'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Votre nom ne peut pas être vide')]
    #[Assert\Length(max: 15, maxMessage: 'Votre nom ne peut pas dépasser 15 caractères')]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Assert\NotBlank(message: 'Votre prénom ne peut pas être vide')]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Assert\NotNull(message: 'Votre date de naissance ne peut pas être vide')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dob = null;

    #[Assert\NotNull(message: 'Votre date de naissance ne peut pas être vide')]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Assert\Count(min: 1, minMessage: 'Au moins un film doit être associé à l\'acteur')]
    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'actor')]
    private Collection $movies;

    #[Assert\Choice(choices: Actor::HEY, message: 'Choose a valid genre.')]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reward = null;

    #[Assert\NotBlank(message: 'La nationalité ne peut pas être vide')]
    #[ORM\Column(length: 255)]
    private ?string $nationality = null;

    #[ORM\ManyToOne(inversedBy: 'actors')]
    private ?MediaObject $MediaObject = null;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(\DateTimeInterface $dob): static
    {
        $this->dob = $dob;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->addActor($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeActor($this);
        }

        return $this;
    }

    public function getReward(): ?string
    {
        return $this->reward;
    }

    public function setReward(?string $reward): static
    {
        $this->reward = $reward;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getMediaObject(): ?MediaObject
    {
        return $this->MediaObject;
    }

    public function setMediaObject(?MediaObject $MediaObject): static
    {
        $this->MediaObject = $MediaObject;

        return $this;
    }
}

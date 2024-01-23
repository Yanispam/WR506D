<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource]
#[ApiFilter(SearchFilter::class, properties: ['title'=>'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['title'=>'ASC'])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Votre titre ne peut pas être vide')]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    private Collection $actor;

    #[Assert\NotNull(message: 'La date de sortie ne peut pas être vide')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $release_date = null;

    #[Assert\NotBlank(message: 'La description ne peut pas être vide')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\Range(min: 1, max: 300, notInRangeMessage: 'La durée doit être entre 1 et 300 minutes')]
    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[Assert\Range(min: 0, max: 10, notInRangeMessage: 'La note doit être entre 0 et 10')]
    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[Assert\Range(min: 1, notInRangeMessage: 'Les entrées doivent être au moins 1')]
    #[ORM\Column(nullable: true)]
    private ?int $entries = null;

    #[Assert\Range(min: 0, notInRangeMessage: 'Le budget ne peut pas être négatif')]
    #[ORM\Column(nullable: true)]
    private ?int $budget = null;

    #[Assert\NotBlank(message: 'Le réalisateur ne peut pas être vide')]
    #[ORM\Column(length: 255)]
    private ?string $director = null;

    #[Assert\Url(message: 'Le site web doit être une URL valide')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'movies')]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?MediaObject $MediaObject = null;

    public function __construct()
    {
        $this->actor = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actor->contains($actor)) {
            $this->actor->add($actor);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        $this->actor->removeElement($actor);

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(?\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getEntries(): ?int
    {
        return $this->entries;
    }

    public function setEntries(?int $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addMovie($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeMovie($this);
        }

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

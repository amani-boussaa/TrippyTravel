<?php

namespace App\Entity;

use App\Repository\ExcursionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExcursionRepository::class)
 * @Vich\Uploadable()
 */
class Excursion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("excursion")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $ville;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Type(
     *     type="float",
     *     message="La valeur {{ value }} est non valide {{ type }}."
     * )
     * @Groups("excursion")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Excursioncategorie::class, inversedBy="excursions",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $excursioncategorie;


    /**
     * @ORM\OneToMany(targetEntity=Excursionimage::class, mappedBy="excursion", cascade={"persist", "remove"})
     * @Assert\Valid()
     * @Groups("excursion")
     */
    private $excursionimages;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $duration;

    /**
     * @ORM\OneToMany(targetEntity=Excursionreservation::class, mappedBy="excursion", cascade={"persist", "remove"})
     * @Groups("excursion")
     */
    private $excursionreservations;

    /**
     * @ORM\OneToMany(targetEntity=Excursioncomment::class, mappedBy="excursion", cascade={"persist", "remove"})
     * @Groups("excursion")
     */
    private $excursioncomments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $localisation;

    public function __construct()
    {
        $this->excursionimages = new ArrayCollection();
        $this->excursionreservations = new ArrayCollection();
        $this->excursioncomments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getExcursioncategorie(): ?excursioncategorie
    {
        return $this->excursioncategorie;
    }

    public function setExcursioncategorie(?excursioncategorie $excursioncategorie): self
    {
        $this->excursioncategorie = $excursioncategorie;

        return $this;
    }


    /**
     * @return Collection<int, Excursionimage>
     */
    public function getExcursionimages(): Collection
    {
        return $this->excursionimages;
    }

    public function addExcursionimage(Excursionimage $excursionimage): self
    {
        $excursionimage->setExcursion($this);
        $this->excursionimages[] = $excursionimage;

        return $this;
    }

    public function removeExcursionimage(Excursionimage $excursionimage): self
    {
        if ($this->excursionimages->removeElement($excursionimage)) {
            // set the owning side to null (unless already changed)
            if ($excursionimage->getExcursion() === $this) {
                $excursionimage->setExcursion(null);
            }
        }

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Excursionreservation>
     */
    public function getExcursionreservations(): Collection
    {
        return $this->excursionreservations;
    }

    public function addExcursionreservation(Excursionreservation $excursionreservation): self
    {
        if (!$this->excursionreservations->contains($excursionreservation)) {
            $this->excursionreservations[] = $excursionreservation;
            $excursionreservation->setExcursion($this);
        }

        return $this;
    }

    public function removeExcursionreservation(Excursionreservation $excursionreservation): self
    {
        if ($this->excursionreservations->removeElement($excursionreservation)) {
            // set the owning side to null (unless already changed)
            if ($excursionreservation->getExcursion() === $this) {
                $excursionreservation->setExcursion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Excursioncomment>
     */
    public function getExcursioncomments(): Collection
    {
        return $this->excursioncomments;
    }

    public function addExcursioncomment(Excursioncomment $excursioncomment): self
    {
        if (!$this->excursioncomments->contains($excursioncomment)) {
            $this->excursioncomments[] = $excursioncomment;
            $excursioncomment->setExcursion($this);
        }

        return $this;
    }

    public function removeExcursioncomment(Excursioncomment $excursioncomment): self
    {
        if ($this->excursioncomments->removeElement($excursioncomment)) {
            // set the owning side to null (unless already changed)
            if ($excursioncomment->getExcursion() === $this) {
                $excursioncomment->setExcursion(null);
            }
        }

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }


}
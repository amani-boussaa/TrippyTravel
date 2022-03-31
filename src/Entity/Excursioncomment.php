<?php

namespace App\Entity;

use App\Repository\ExcursioncommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=ExcursioncommentRepository::class)
 */
class Excursioncomment
{
    public function __construct() {
        $this->setCreatedAt(new \DateTime());
        $this->setActif(true);
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("excursion")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $contenu;

    /**
     *  @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $actif;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Groups("excursion")
     */
    private $rgpd;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("excursion")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Excursion::class, inversedBy="excursioncomments")
     */
    private $excursion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getActif(): ?string
    {
        return $this->actif;
    }

    public function setActif(?string $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getRgpd(): ?string
    {
        return $this->rgpd;
    }

    public function setRgpd(?string $rgpd): self
    {
        $this->rgpd = $rgpd;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getExcursion(): ?Excursion
    {
        return $this->excursion;
    }

    public function setExcursion(?Excursion $excursion): self
    {
        $this->excursion = $excursion;

        return $this;
    }
}
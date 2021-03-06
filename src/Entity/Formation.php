<?php

namespace App\Entity;

use DateTimeInterface;
use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Date
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @Assert\Length(max = 100)
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\Url(
     *    protocols = {"http", "https"},
     *    message = "{{ value }} n'est pas une URL valide."
     * )
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $miniature;

    /**
     * @Assert\Url(
     *    protocols = {"http", "https"},
     *    message = "{{ value }} n'est pas une URL valide."
     * )
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $picture;

    /**
     * @Assert\Length(max = 11)
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $videoId;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="formations")
     */
    private $niveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function getPublishedAtString(): string {
        return $this->publishedAt->format('d/m/Y');     
    }    
        
    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMiniature(): ?string
    {
        return $this->miniature;
    }

    public function setMiniature(?string $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }
    
    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
    
    public function getLevel(): ?string
    {
        return $this->getNiveau()->getLevel();
    }
}

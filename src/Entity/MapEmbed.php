<?php

namespace App\Entity;

use App\Repository\MapEmbedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MapEmbedRepository::class)
 */
class MapEmbed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $iframe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIframe(): ?string
    {
        return $this->iframe;
    }

    public function setIframe(?string $iframe): self
    {
        $this->iframe = $iframe;

        return $this;
    }
}

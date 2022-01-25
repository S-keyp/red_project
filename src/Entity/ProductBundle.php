<?php

namespace App\Entity;

use App\Repository\ProductBundleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductBundleRepository::class)]
class ProductBundle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Name;

    #[ORM\Column(type: 'integer')]
    private $service_price;

    #[ORM\Column(type: 'string', length: 255)]
    private $description_service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getServicePrice(): ?int
    {
        return $this->service_price;
    }

    public function setServicePrice(int $service_price): self
    {
        $this->service_price = $service_price;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->description_service;
    }

    public function setDescriptionService(string $description_service): self
    {
        $this->description_service = $description_service;

        return $this;
    }
}

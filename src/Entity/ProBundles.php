<?php

namespace App\Entity;

use App\Repository\ProBundlesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProBundlesRepository::class)]
class ProBundles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Assert\NotBlank
     */
    private $titleService;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Assert\NotBlank
     */
    private $descriptionService;

    #[ORM\Column(type: 'integer')]
    private $Professionnal;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_service;

    #[ORM\Column(type: 'float')]
    /**
     * @Assert\Positive
     * @Assert\NotBlank
     */
    private $servicePrice;

    #[ORM\Column(type: 'smallint')]
    private $serviceCategory;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleService(): ?string
    {
        return $this->titleService;
    }

    public function setTitleService(string $titleService): self
    {
        $this->titleService = $titleService;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->descriptionService;
    }

    public function setDescriptionService(string $descriptionService): self
    {
        $this->descriptionService = $descriptionService;

        return $this;
    }

    public function getImageService(): ?int
    {
        return $this->image_service;
    }

    public function setImageService(int $imageService): self
    {
        $this->image_service = $imageService;

        return $this;
    }

    public function getProfessionnal(): ?int
    {
        return $this->Professionnal;
    }

    public function setProfessionnal(int $Professionnal): self
    {
        $this->Professionnal = $Professionnal;

        return $this;
    }

    public function getServicePrice(): ?float
    {
        return $this->servicePrice;
    }

    public function setServicePrice(int $servicePrice): self
    {
        $this->servicePrice = $servicePrice;

        return $this;
    }

    public function getServiceCategory(): ?int
    {
        return $this->serviceCategory;
    }

    public function setServiceCategory(int $serviceCategory): self
    {
        $this->serviceCategory = $serviceCategory;

        return $this;
    }
}

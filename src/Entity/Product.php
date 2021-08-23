<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class) *
 */
#[ApiResource(
	itemOperations: [
		'get' => [
			'normalization_context' => ['groups' => ['read:Product:collection', 'read:Product:item']]
		]
	],
	normalizationContext: ['groups' => ['read:Product:collection']]
)]
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
	#[Groups('read:Product:collection')]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
	#[Groups('read:Product:collection')]
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
	#[Groups('read:Product:item')]
    private $os;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
	#[Groups('read:Product:item')]
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
	#[Groups('read:Product:item')]
    private $price;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
	#[Groups('read:Product:item')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOs(): ?int
    {
        return $this->os;
    }

    public function setOs(int $os): self
    {
        $this->os = $os;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

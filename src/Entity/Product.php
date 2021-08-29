<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class) *
 */
#[ApiResource(
	collectionOperations: ['get'],
	itemOperations: [
		'get' => [
			'normalization_context' => [
				'groups' => ['read:Product:collection', 'read:Product:item'],
				'openapi_definition_name' => 'Detail'
			]
		]
	],
	normalizationContext: [
		'groups' => ['read:Product:collection'],
		'openapi_definition_name' => 'Collection'
		],
	order: ['name'],
	paginationItemsPerPage: 20
),
]
class Product
{
	const OS = [
		0 => 'Apple',
		1 => 'Android',
		3 => 'Windows Phone'
	];
	
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
	#[Groups('read:Product:collection'),
	Length(min: 3),
	NotBlank]
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
	#[Groups('read:Product:item'),
	NotBlank]
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

    public function getOs(): ?string
    {
        return self::OS[$this->os];
    }

    public function setOs(string $os): self
    {
    	$array_os = array_flip(self::OS);
        $this->os = $array_os[$os];

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

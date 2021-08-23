<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[ApiResource(
	itemOperations: [
		'put',
		'delete',
		'get' => [
			'normalization_context' => ['groups' => ['read:User:collection', 'read:User:item', 'read:Customer']]
		]
	],
	denormalizationContext: ['groups' => ['write:User']],
	normalizationContext: ['groups' => ['read:User:collection']]
)]
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
	#[Groups('read:User:collection')]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
	#[Groups(['read:User:collection', 'write:User'])]
	
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
	#[Groups(['read:User:collection', 'write:User'])]
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
	#[Groups(['write:User'])]
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
	#[Groups(['read:User:item', 'write:User'])]
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
	#[Groups(['read:User:item', 'write:User'])]
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="users")
	 * @ORM\JoinColumn(nullable=false)
     */
	#[Groups(['write:User'])]
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}

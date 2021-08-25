<?php

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
#[ApiResource(
	collectionOperations: [],
	itemOperations: [
		'get' => [
			'controller'      => NotFoundAction::class,
			'openapi_context' => [
				'summary' => 'hidden'
			],
			'read'            => false,
			'output'          => false
		]
	]
)]
class Customer implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	#[Groups(['read:Customer'])]
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=180, unique=true)
	 */
	private $siret;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	#[Groups(['read:Customer'])]
	private $name;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $email;
	
	/**
	 * @ORM\Column(type="string", length=50, nullable=true)
	 */
	private $phoneNumber;
	
	/**
	 * @ORM\Column(type="json")
	 */
	private $roles = [];
	
	/**
	 * @var string The hashed password
	 * @ORM\Column(type="string")
	 */
	private $password;
	
	/**
	 * @ORM\OneToMany(targetEntity=User::class, mappedBy="customer")
	 */
	private $users;
	
	public function __construct()
	{
		$this->users = new ArrayCollection();
	}
	
	public function getId(): ?int
	{
		return $this->id;
	}
	
	public function setId(?int $id): self
	{
		$this->id = $id;
		return $this;
	}
	
	public function getSiret(): ?string
	{
		return $this->siret;
	}
	
	public function setSiret(string $siret): self
	{
		$this->siret = $siret;
		return $this;
	}
	
	/**
	 * A visual identifier that represents this user.
	 *
	 * @see UserInterface
	 */
	public function getUserIdentifier(): string
	{
		return (string)$this->siret;
	}
	
	/**
	 * @deprecated since Symfony 5.3, use getUserIdentifier instead
	 */
	public function getUsername(): string
	{
		return (string)$this->siret;
	}
	
	/**
	 * @see UserInterface
	 */
	public function getRoles(): array
	{
		$roles = $this->roles;
		// guarantee every user at least has ROLE_USER
		$roles[] = 'ROLE_USER';
		
		return array_unique($roles);
	}
	
	public function setRoles(array $roles): self
	{
		$this->roles = $roles;
		return $this;
	}
	
	/**
	 * @see PasswordAuthenticatedUserInterface
	 */
	public function getPassword(): string
	{
		return $this->password;
	}
	
	public function setPassword(string $password): self
	{
		$this->password = $password;
		return $this;
	}
	
	/**
	 * Returning a salt is only needed, if you are not using a modern
	 * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
	 *
	 * @see UserInterface
	 */
	public function getSalt(): ?string
	{
		return null;
	}
	
	/**
	 * @see UserInterface
	 */
	public function eraseCredentials()
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}
	
	/**
	 * @return mixed
	 */
	public function getName(): ?string
	{
		return $this->name;
	}
	
	/**
	 * @param mixed $name
	 *
	 * @return Customer
	 */
	public function setName($name): self
	{
		$this->name = $name;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}
	
	/**
	 * @param mixed $email
	 *
	 * @return Customer
	 */
	public function setEmail($email): self
	{
		$this->email = $email;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPhoneNumber(): ?string
	{
		return $this->phoneNumber;
	}
	
	/**
	 * @param mixed $phoneNumber
	 *
	 * @return Customer
	 */
	public function setPhoneNumber($phoneNumber): self
	{
		$this->phoneNumber = $phoneNumber;
		return $this;
	}
	
	/**
	 * @return Collection|User[]
	 */
	public function getUsers(): Collection
	{
		return $this->users;
	}
	
	public function addUser(User $user): self
	{
		if (!$this->users->contains($user)) {
			$this->users[] = $user;
			$user->setCustomer($this);
		}
		return $this;
	}
	
	public function removeUser(User $user): self
	{
		if ($this->users->removeElement($user)) {
			// set the owning side to null (unless already changed)
			if ($user->getCustomer() === $this) {
				$user->setCustomer(null);
			}
		}
		return $this;
	}
	
	/**
	 * @param string $username
	 * @param array  $payload
	 *
	 * @return JWTUserInterface
	 */
	public static function createFromPayload($id, array $payload)
	{
		return (new Customer())->setId($id);
	}
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\CustomerRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;


class UserFixtures extends Fixture
{
	public function __construct(private UserPasswordHasherInterface $passwordHasher, private CustomerRepository $customerRepository)
	{
	}
	
	public function load(ObjectManager $manager)
	{
		$faker = Factory::create('fr_FR');
		$customers = $this->customerRepository->findAll();
		foreach ($customers as $customer) {
			for ($i = 0; $i < mt_rand(3, 10); $i++) {
				$user = new User();
				$user->setFirstName($faker->firstName)
					->setLastName($faker->lastName)
					->setPhoneNumber($faker->phoneNumber)
					->setPassword($faker->password)
					->setEmail($faker->email)
					->setCustomer($customer);
				$manager->persist($user);
			}
		}
		$manager->flush();
	}
}
<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;


class CustomerFixtures extends Fixture
{
	public function __construct(private UserPasswordHasherInterface $passwordHasher)
	{
	}
	
	public function load(ObjectManager $manager)
	{
		$faker = Factory::create('fr_FR');
		for ($i = 0; $i < 10; $i++) {
			$customer = new Customer();
			$customer->setSiret($faker->numberBetween(100000000,999999999))
				->setName($faker->company)
				->setPhoneNumber($faker->phoneNumber)
				->setRoles(['ROLE_USER'])
				->setEmail($faker->email)
				->setPassword($this->passwordHasher->hashPassword($customer, $faker->password));
			$manager->persist($customer);
		}
		
		$customer = new Customer();
		$customer->setSiret('demo')
			->setName($faker->company)
			->setPhoneNumber($faker->phoneNumber)
			->setRoles(['ROLE_USER'])
			->setEmail($faker->email)
			->setPassword($this->passwordHasher->hashPassword($customer, 'demo'));
		$manager->persist($customer);
		
		$manager->flush();
	}
}

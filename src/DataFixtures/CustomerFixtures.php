<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class CustomerFixtures extends Fixture
{
	public function __construct(private UserPasswordHasherInterface $passwordHasher)
	{
	}
	
	public function load(ObjectManager $manager)
	{
		$customer = new Customer();
		$customer->setSiret('3')
			->setName('test3')
			->setPhoneNumber('03')
			->setRoles(['ROLE_USER'])
			->setEmail('test3@gmail.com')
			->setPassword($this->passwordHasher->hashPassword($customer, 'demo'));
		$manager->persist($customer);
		$manager->flush();
	}
}

<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;


class ProductFixtures extends Fixture
{
	public function __construct(private UserPasswordHasherInterface $passwordHasher)
	{
	}
	
	public function load(ObjectManager $manager)
	{
		$faker = Factory::create('fr_FR');
		for ($i = 0; $i < 20; $i++) {
			$product = new Product();
			$product->setName($faker->word)
				->setDescription($faker->sentences(4, true))
				->setOs(1)
				->setCreatedAt(new \DateTimeImmutable())
				->setPrice($faker->randomFloat(1, 50, 2000));
			$manager->persist($product);
		}
		$manager->flush();
	}
}
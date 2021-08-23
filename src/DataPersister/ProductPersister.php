<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductPersister implements DataPersisterInterface
{
	
	/**
	 * @var EntityManagerInterface
	 */
	private $em;
	
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}
	
	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public function supports($data): bool
	{
		return $data instanceof Product;
	}
	
	/**
	 * @param $data
	 *
	 * @return object|void
	 */
	public function persist($data)
	{
		$data->setCreatedAt(new \DateTimeImmutable());
		$this->em->persist($data);
		$this->em->flush();
	}
	
	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	public function remove($data)
	{
		$this->em->remove($data);
		$this->em->flush();
	}
}
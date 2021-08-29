<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Customer;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentCustomerExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
	
	public function __construct(private Security $security)
	{
	}
	
	/**
	 * @param QueryBuilder                $queryBuilder
	 * @param QueryNameGeneratorInterface $queryNameGenerator
	 * @param string                      $resourceClass
	 * @param string|null                 $operationName
	 *
	 * @return void
	 */
	public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
	{
		$this->addWhere($resourceClass, $queryBuilder);
	}
	
	/**
	 * @param QueryBuilder                $queryBuilder
	 * @param QueryNameGeneratorInterface $queryNameGenerator
	 * @param string                      $resourceClass
	 * @param array                       $identifiers
	 * @param string|null                 $operationName
	 * @param array                       $context
	 *
	 * @return void
	 */
	public function applyToItem(QueryBuilder $queryBuilder,
								QueryNameGeneratorInterface $queryNameGenerator,
								string $resourceClass,
								array $identifiers,
								string $operationName = null,
								array $context = [])
	{
		$this->addWhere($resourceClass, $queryBuilder);
	}
	
	private function addWhere(string $resourceClass, QueryBuilder $queryBuilder)
	{
		if ($resourceClass === User::class) {
			$alias = $queryBuilder->getRootAliases()[0];
			$queryBuilder->andWhere("$alias.customer = :customer")
				->setParameter('customer', $this->security->getUser()->getId());
		}
	}
}
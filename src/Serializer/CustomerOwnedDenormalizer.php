<?php

namespace App\Serializer;

use App\Entity\User;
use App\Repository\CustomerRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class CustomerOwnedDenormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
	use DenormalizerAwareTrait;
	
	private const ALREADY_CALLED_DENORMALIZER = 'CustomerOwnedDenormalizerCalled';
	
	public function __construct(private Security $security, private CustomerRepository $repository) {}
	
	/**
	 * @param mixed       $data
	 * @param string      $type
	 * @param string|null $format
	 * @param array       $context
	 *
	 * @return bool
	 */
	public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
	{
		$alreadyCalled = $context[self::ALREADY_CALLED_DENORMALIZER] ?? false;
		return $type === User::class && $alreadyCalled === false;
	}
	
	/**
	 * @param mixed       $data
	 * @param string      $type
	 * @param string|null $format
	 * @param array       $context
	 *
	 * @return mixed
	 */
	public function denormalize($data, string $type, string $format = null, array $context = [])
	{
		$customer = $this->repository->find($this->security->getUser()->getId());
		$context[self::ALREADY_CALLED_DENORMALIZER] = true;
		$obj = $this->denormalizer->denormalize($data, $type, $format, $context);
		$obj->setCustomer($customer);
		return $obj;
	}
}
<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;

class OpenApiFactory implements OpenApiFactoryInterface
{
	
	public function __construct(private OpenApiFactoryInterface $decorated)	{}
	
	/**
	 * @param array $context
	 *
	 * @return OpenApi
	 */
	public function __invoke(array $context = []): OpenApi
	{
		$openApi= $this->decorated->__invoke($context);
		/** @var PathItem $path */
		foreach ($openApi->getPaths()->getPaths() as $key => $path) {
			if ($path->getGet() && $path->getGet()->getSummary() === 'hidden') {
				$openApi->getPaths()->addPath($key, $path->withGet(null));
			}
		}
		
		$schemas = $openApi->getComponents()->getSchemas();
		$schemas['Credentials'] = new \ArrayObject([
			'type' => 'object',
			'properties' => [
				'username' => [
					'type' => 'string',
					'example' => '36252187900034'
				],
				'password' => [
					'type' => 'string',
					'example' => 'demo'
				]
			]
		]);
		
		$schemas['Token'] = new \ArrayObject([
			'type' => 'object',
			'properties' => [
				'token' => [
					'type' => 'string',
					'readOnly' => true
				],
				'refresh_token' => [
					'type' => 'string',
					'readOnly' => true
				]
			]
		]);
		
		$schemas['RefreshToken'] = new \ArrayObject([
			'type' => 'object',
			'properties' => [
				'refresh_token' => [
					'type' => 'string',
					'example' => '6fd8a62bfa429c4841b299b988a42b191d8e6a62f3a84ace5caf5e1f92973fdf03ed273e8d1dac78202dce7d04f6268237ad44bd41e97010b0afb5633772a5dd'
				]
			]
		]);
		
		$pathItem = new PathItem(
			post: new Operation(
				operationId: 'postApiLogin',
				tags: ['Auth'],
				responses: [
					'200' => [
						'description' => 'JWT Token',
						'content' => [
							'application/json' => [
								'schema' => [
									'$ref' => '#/components/schemas/Token'
								]
							]
						]
					]
				],
				requestBody: new RequestBody(
					content: new \ArrayObject([
						'application/json' => [
							'schema' => [
								'$ref' => '#/components/schemas/Credentials'
							]
						]
					])
				)
			)
		);
		$openApi->getPaths()->addPath('/api/login_check', $pathItem);
		
		$pathItem = new PathItem(
			post: new Operation(
				operationId: 'postApiLogout',
				tags: ['Auth'],
				responses: [
					'204' => []
				]
			)
		);
		$openApi->getPaths()->addPath('/api/logout', $pathItem);
		
		$pathItem = new PathItem(
			post: new Operation(
				operationId: 'postApiRefreshToken',
				tags: ['Auth'],
				responses: [
					'200' => [
						'description' => 'JWT Token Refresh',
						'content' => [
							'application/json' => [
								'schema' => [
									'$ref' => '#/components/schemas/Token'
								]
							]
						]
					]
				],
				requestBody: new RequestBody(
					content: new \ArrayObject([
						'application/json' => [
							'schema' => [
								'$ref' => '#/components/schemas/RefreshToken'
							]
						]
					])
				)
			)
		);
		$openApi->getPaths()->addPath('/api/token/refresh', $pathItem);
		
		return $openApi;
	}
}
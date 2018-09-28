<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.03.2018
 * Time: 20:49
 */

namespace System\Service;

use Exception\ServiceException;
use Traits\SingletonTrait;

class ServiceContainer implements ServiceContainerInterface
{
	use SingletonTrait;

	/**
	 * @var ServiceInterface[]
	 */
	private $instanceService = [];

	private $services = [];

	private $servicesConfig = [];

	public function setServiceConfig(array $serviceConfig): ServiceContainerInterface
	{
		if (empty($serviceConfig)) {
			return $this;
		}

		$this->servicesConfig = $serviceConfig;
		return $this;
	}

	public function addService(string $service): ServiceContainerInterface
	{
		if (!isset($this->services[$service])) {
			$this->services[$service] = $this->servicesConfig[$service];
		}

		return $this;
	}

	public function getService(string $service): ServiceInterface
	{
		if (isset($this->services[$service])) {

			if (!isset($this->instanceService[$service])) {
				$this->createInstance($service, $this->services[$service]['class']);
			}
			return $this->instanceService[$service];
		}

		throw ServiceException::notFound([$service]);
	}

	private function createInstance(string $service, $serviceClass)
	{
		/** @var ServiceInterface $class */
		$class = new $serviceClass();
		$this->instanceService[$service] = $class;
		$class->setArguments($this->services[$service]['arguments']);
	}


}
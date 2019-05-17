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

	/**
	 * @var array
	 */
	private $services = [];

	/**
	 * @var array
	 */
	private $servicesConfig = [];

	/**
	 * @var ServiceInterface
	 */
	private $class;

	/**
	 * @param array $serviceConfig
	 * @return ServiceContainerInterface
	 */
	public function setServiceConfig(array $serviceConfig): ServiceContainerInterface
	{
		if (empty($serviceConfig)) {
			return $this;
		}

		$this->servicesConfig = $serviceConfig;
		return $this;
	}

	/**
	 * @param string $service
	 * @return ServiceContainerInterface
	 */
	public function add(string $service): ServiceContainerInterface
	{
		if (!isset($this->services[$service])) {
			$this->services[$service] = $this->servicesConfig[$service];
		}

		return $this;
	}

	/**
	 * @param string $service
	 * @return ServiceInterface
	 * @throws ServiceException
	 */
	public function get(string $service): ServiceInterface
	{
		if (isset($this->services[$service])) {

			if (!isset($this->instanceService[$service])) {
				$this->createInstance($service, $this->services[$service]['class']);
			}
			return $this->instanceService[$service];
		}

		throw ServiceException::notFound([$service]);
	}

	/**
	 * @param string $service
	 * @param $serviceClass string
	 */
	private function createInstance(string $service, string $serviceClass)
	{
		$this->class = new $serviceClass();
		$this->instanceService[$service] = $this->class;
		$this->class->setArguments($this->services[$service]['arguments']);
	}


}
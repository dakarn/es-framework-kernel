<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19.03.2018
 * Time: 22:48
 */

namespace ES\Kernel\System\Service;

interface ServiceContainerInterface
{
	/**
	 * @param string $service
	 * @return ServiceContainerInterface
	 */
	public function add(string $service): ServiceContainerInterface;

	/**
	 * @param string $service
	 * @return ServiceInterface
	 */
	public function get(string $service): ServiceInterface;

	/**
	 * @param array $serviceConfig
	 * @return ServiceContainerInterface
	 */
	public function setServiceConfig(array $serviceConfig): ServiceContainerInterface;
}
<?php

namespace System\Kernel;

use Exception\FileException;
use Exception\ObjectException;

class LoaderClass
{
	const DEFAULT_DIR_SYSTEM = [
		'Config',
		'Exception',
		'ElasticSearch',
		'Helper',
		'Traits',
		'Middleware',
		'Providers',
		'System',
		'Queue',
		'TypesApp',
		'Widget',
		'Http',
		'MicroServices'
	];

	const EXTENSION = '.php';

	public function __construct()
	{
		include(PATH_SYSTEM .'System/DefineSetup.php');
		include(APP_EVENT);
		include(APP_KERNEL);
	}

	public function loader()
	{
		spl_autoload_register(function ($class) {

			$pathClass      = str_replace('\\', '/', $class);
			$rootPath       = $this->pathAppOrSystem($class);
			$pathForInclude = $rootPath . $pathClass . self::EXTENSION;

			if (!file_exists($pathForInclude)) {
				throw FileException::notFound([$pathClass]);
			}

			include_once($pathForInclude);

			if (!class_exists($class)) {
				if (!interface_exists($class)) {
					if (!trait_exists($class)) {
						throw ObjectException::notFound([$class]);
					}
				}
			}
		});
	}

	private function pathAppOrSystem(string $class): string
	{
		$findOtherDir = array_search(substr($class, 0, strpos($class, '\\')), self::DEFAULT_DIR_SYSTEM);

		if ($findOtherDir !== false) {
			return PATH_SYSTEM;
		}

		return PATH_APP;
	}

}

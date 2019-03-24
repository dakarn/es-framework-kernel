<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.10.2018
 * Time: 17:20
 */

namespace System\Auth;

use Helper\RepositoryHelper\AbstractRepository;
use System\Database\ORM\Mapping\ObjectMapper;
use System\Validators\AbstractValidator;

class ClientAppRepository extends AbstractRepository
{
	/**
	 * @param AbstractValidator $validator
	 * @return ClientApp
	 * @throws \Exception
	 */
	public function loadClientApp(AbstractValidator $validator):? ClientApp
	{
		$result = $this->getStorage()->loadClientApp($validator);

		if (!empty($result)) {
			if ($result['site'] !== $validator->getValueField('site')) {
				return null;
			}

			$this->isLoaded = true;
		}

		$this->resultOperation = ObjectMapper::create()->arrayToObject($result, ClientApp::class);

		return $this->resultOperation;
	}

	/**
	 * @return ClientAppStorage
	 */
	private function getStorage(): ClientAppStorage
	{
		if (!$this->storage instanceof ClientAppStorage) {
			$this->storage = new ClientAppStorage();
		}

		return $this->storage;
	}
}
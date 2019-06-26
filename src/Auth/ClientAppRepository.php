<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.10.2018
 * Time: 17:20
 */

namespace ES\Kernel\Auth;

use ES\Kernel\Helper\RepositoryHelper\AbstractRepository;
use ES\Kernel\ObjectMapper\ObjectMapper;
use ES\Kernel\Validators\AbstractValidator;

class ClientAppRepository extends AbstractRepository
{
	/**
	 * @param AbstractValidator $validator
	 * @return ClientApp
	 * @throws \Exception
	 */
	public function loadClientApp(AbstractValidator $validator): ?ClientApp
	{
		$result = $this->getStorage()->loadClientApp($validator);

		if (!empty($result)) {
			if ($result->getSite() !== $validator->getValueField('site')) {
				return null;
			}

			$this->isLoaded = true;
		}

		$this->resultOperation = $result;

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
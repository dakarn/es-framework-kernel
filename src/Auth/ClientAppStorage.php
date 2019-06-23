<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:57
 */

namespace ES\Kernel\Auth;

use ES\Kernel\Database\DB;
use ES\Kernel\Helper\StorageHelper\AbstractStorage;
use ES\Kernel\Validators\AbstractValidator;

class ClientAppStorage extends AbstractStorage
{
	public function packToObject($classToMapping)
	{
		parent::packToObject($classToMapping);
		return $this;
	}

	/**
	 * @param AbstractValidator $validator
	 * @return ClientApp
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\ObjectException
	 */
	public function loadClientApp(AbstractValidator $validator): ClientApp
	{
		return DB::getMySQL()->getESFramework()->fetchRowToObject('
			SELECT * 
			FROM 
				`access_application`
			WHERE 
				`clientId` = \'' . $validator->getValueField('clientId') . '\'
				AND 
				`clientSecret` = \'' . $validator->getValueField('clientSecret') . '\'
			LIMIT 1
		', $this->classToMapping);
	}
}
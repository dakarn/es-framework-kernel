<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:57
 */

namespace ES\Kernel\Auth;

use ES\Kernel\Exception\ObjectException;
use ES\Kernel\Helper\StorageHelper\EsFrameworkMySQLStorage;
use ES\Kernel\Validators\AbstractValidator;

class ClientAppStorage extends EsFrameworkMySQLStorage
{
    /**
     * @return string
     */
    protected function getObjectName(): string
    {
        return ClientApp::class;
    }

	/**
	 * @param AbstractValidator $validator
	 * @return ClientApp
     * @throws ObjectException
	 */
	public function loadClientApp(AbstractValidator $validator): ClientApp
	{
		return $this->fetchRowToObject('
			SELECT * 
			FROM 
				`access_application`
			WHERE 
				`clientId` = \'' . $validator->getValueField('clientId') . '\'
				AND 
				`clientSecret` = \'' . $validator->getValueField('clientSecret') . '\'
			LIMIT 1
		');
	}
}
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:57
 */

namespace System\Auth;

use System\Database\DB;
use System\Validators\AbstractValidator;

class ClientAppStorage
{
	/**
	 * @param AbstractValidator $validator
	 * @return array
	 * @throws \Exception
	 */
	public function loadClientApp(AbstractValidator $validator): array
	{
		return DB::MySQLAdapter()->fetchRow('
			SELECT * 
			FROM 
				`access_application`
			WHERE 
				`clientId` = \'' . $validator->getValueField('clientId') . '\'
				AND 
				`clientSecret` = \'' . $validator->getValueField('clientSecret') . '\'
			LIMIT 1
		') ?? [];
	}
}
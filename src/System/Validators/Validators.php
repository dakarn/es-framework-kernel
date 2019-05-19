<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.10.2018
 * Time: 0:07
 */

namespace ES\Kernel\System\Validators;

interface Validators
{
	public const REGISTER  = 'RegisterValidator';
	public const AUTH      = 'AuthValidator';
	public const COMMON    = 'common';
	public const AUTH_APP  = 'AuthAppValidator';
	public const REF_TOKEN = 'RefreshTokenValidator';

	public const ADD_WORD  = 'AddWordValidator';
	public const EDIT_WORD = 'EditWordValidator';

	public const SUCCESS   = 'Success';
}
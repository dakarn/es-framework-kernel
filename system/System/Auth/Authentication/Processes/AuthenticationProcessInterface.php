<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.03.2019
 * Time: 21:18
 */

namespace System\Auth\Authentication\Processes;

interface AuthenticationProcessInterface
{
	public function execute(): bool;
}
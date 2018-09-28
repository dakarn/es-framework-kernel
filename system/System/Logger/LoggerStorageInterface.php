<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.04.2018
 * Time: 2:02
 */

namespace System\Logger;

interface LoggerStorageInterface
{
	public function addLog(string $level, string $message): LoggerStorageInterface;

	public function getLog(): array;

	public function releaseLog(): void;
}
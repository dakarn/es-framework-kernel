<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 15:27
 */

namespace System\Validators;

interface AbstractValidatorInterface
{
	public function getErrors(): array;

	public function getError(string $field): string;

	public function getErrorsApi(): array;

	public function isPost(): bool;

	public function isGet(): bool;

	public function isValid(): bool;
}
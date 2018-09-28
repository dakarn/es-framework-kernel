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
	/**
	 * @return array
	 */
	public function getErrors(): array;

	/**
	 * @param string $field
	 * @return string
	 */
	public function getError(string $field): string;

	/**
	 * @return array
	 */
	public function getErrorsApi(): array;

	/**
	 * @return bool
	 */
	public function isPost(): bool;

	/**
	 * @return bool
	 */
	public function isGet(): bool;

	/**
	 * @return bool
	 */
	public function isValid(): bool;
}
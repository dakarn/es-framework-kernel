<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.10.2018
 * Time: 19:18
 */

namespace ES\Kernel\System\Validators;

interface AbstractValidatorInterface
{
	/**
	 * @return AbstractValidator
	 */
	public function setUseIfPost(): AbstractValidator;

	/**
	 * @return array
	 */
	public function getErrorsApi(): array;

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function getValueField(string $key);

	/**
	 * @param string $key
	 * @return string
	 */
	public function getValueFieldForSQL(string $key);

	/**
	 * @return AbstractValidator
	 */
	public function setFlashErrors(): AbstractValidator;

	/**
	 * @param string $text
	 * @return AbstractValidator
	 */
	public function setFlashError(string $text): AbstractValidator;

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
	 * @return mixed
	 */
	public function validateCSRFToken();

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

	/**
	 * @param string $keyError
	 * @return AbstractValidator
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function setExtraError(string $keyError): AbstractValidator;

	/**
	 * @param array $errors
	 * @return AbstractValidator
	 */
	public function setExtraErrorArray(array $errors): AbstractValidator;

	/**
	 * @param string $keyError
	 * @param string $itemError
	 * @return AbstractValidator
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function setExtraErrorAPI(string $keyError, string $itemError = ''): AbstractValidator;

	/**
	 * @return mixed
	 */
	public function validate();
}
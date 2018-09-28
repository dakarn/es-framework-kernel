<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 15:27
 */

namespace System\Validators;

use Http\Cookie;
use Helper\CSRFTokenManager;
use Helper\FlashText;
use Http\Request\ServerRequest;

abstract class AbstractValidator implements AbstractValidatorInterface
{
	/**
	 * @var string
	 */
	private const POST = 'POST';

	/**
	 * @var string
	 */
	private const GET = 'GET';

    /**
     * @var array
     */
	private const DEFAULT_ERROR = [
	    'csrfToken' => 'Отпарвлена невлидная форма'
    ];

	/**
	 * @var array
	 */
	protected $stackErrors = [];

	/**
	 * @var bool
	 */
	public $isUseFlashErrors = false;

	/**
	 * @return array
	 */
	public function getErrorsApi(): array
	{
		$errors = [
			'errors' => []
		];

		foreach ($this->stackErrors as $errorItem => $errorText) {
			$errors['errors'][] = [
				$errorItem => $errorText
			];
		}

		return $errors;
	}

	/**
	 * @return AbstractValidator
	 */
	public function setFlashErrors(): self
	{
		if (!$this->isUseFlashErrors) {
			return $this;
		}

		foreach ($this->stackErrors as $errorText) {
			FlashText::add('danger', $errorText);
		}

		return $this;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->stackErrors;
	}

	/**
	 * @param string $field
	 * @return string
	 */
	public function getError(string $field): string
	{
		return $this->stackErrors[$field] ?? '';
	}

	public function validateCSRFToken()
	{
		$isValid =  CSRFTokenManager::create()
			->setValidationData(
				Cookie::create()->get('CSRFToken'),
				ServerRequest::create()->takePost('CSRFToken'))
			->isValid();

		if (!$isValid) {
            $this->stackErrors['token'] = self::DEFAULT_ERROR['csrfToken'];
        }
	}

	/**
	 * @return bool
	 */
	public function isPost(): bool
	{
		return ServerRequest::create()->getMethod() === self::POST;
	}

	/**
	 * @return bool
	 */
	public function isGet(): bool
	{
		return ServerRequest::create()->getMethod() === self::GET;
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool
	{
		$this->validate();
		$this->setFlashErrors();

		return empty($this->stackErrors);
	}

	/**
	 * @return mixed
	 */
	abstract public function validate();
}
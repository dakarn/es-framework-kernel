<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 15:27
 */

namespace System\Validators;

use Helper\CSRFToken;
use Helper\FlashText;
use Http\Request\Request;

abstract class AbstractValidator implements AbstractValidatorInterface
{
	protected $stackErrors = [];

	public $isUseFlashErrors = false;

	private $post = 'POST';

	private $get  = 'GET';


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

	public function getErrors(): array
	{
		return $this->stackErrors;
	}

	public function getError(string $field): string
	{
		return $this->stackErrors[$field] ?? '';
	}

	public function isCSRFToken(): bool
	{
		return CSRFToken::create()
			->setValidationData(
				Request::create()->getCookie()->get('CSRFToken'),
				Request::create()->takePost('CSRFToken'))
			->isValid();
	}

	public function isPost(): bool
	{
		return Request::create()->getMethod() === $this->post;
	}

	public function isGet(): bool
	{
		return Request::create()->getMethod() === $this->get;
	}

	public function isValid(): bool
	{
		$this->validate();
		$this->setFlashErrors();

		return empty($this->stackErrors);
	}

	abstract public function validate();
}
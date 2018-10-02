<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 15:27
 */

namespace System\Validators;

use Configs\Config;
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
	    'csrfToken' => 'Отправлена невлидная форма'
    ];

	private $useIfPost = false;
	/**
	 * @var array
	 */
	protected $stackErrors = [];

	/**
	 * @var bool
	 */
	public $isUseFlashErrors = false;

	/**
	 * @return AbstractValidator
	 */
	public function setUseIfPost(): self
	{
		$this->useIfPost = true;

		return $this;
	}

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
	 * @param string $key
	 * @return mixed
	 */
	public function getValueField(string $key)
	{
		return $_POST[$key] ?? '';
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
		if ($this->useIfPost && !$this->isPost()) {
			return false;
		}

		$this->validate();
		$this->setFlashErrors();

		return empty($this->stackErrors);
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return string
	 */
	public function __call($name, $arguments)
	{
		if(\substr($name, 0, 3) === \strtolower(self::GET)) {
			return $_POST[\lcfirst(\substr($name, 3))] ?? '';
		}

		return '';
	}

	/**
	 * @return array
	 * @throws \Exception\FileException
	 */
	protected function getFormMessage(): array
	{
		return Config::get('form-result/form-message', \basename(static::class));
	}

	/**
	 * @return mixed
	 */
	abstract public function validate();
}
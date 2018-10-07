<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 1:21
 */

namespace Models\User;

use Configs\Config;
use Helper\FlashText;
use System\Auth\Authentication\Authentication;
use System\Auth\Authorization\Authorization;
use System\Auth\JWTokenManager;
use Helper\Util;
use System\Validators\AbstractValidator;
use System\Validators\Validators;

class User implements UserInterface
{
	public const ROLE_ADMIN = 0b000001; //64
	public const ROLE_USER  = 0b000001; //1
	public const ROLE_MODER = 0b000100; //2

	/**
	 * @var bool
	 */
	private $isAuth = false;

	/**
	 * @var bool
	 */
	private $isLoaded = false;

	/**
	 * @var int
	 */
	private $userId = 0;

	/**
	 * @var string
	 */
	private $login = '';

	/**
	 * @var string
	 */
	private $password = '';

	/**
	 * @var string
	 */
	private $email = '';

	/**
	 * @var int
	 */
	private $role = 0;

	/**
	 * @var bool
	 */
	private $isSaved =  false;

	/**
	 * @var string
	 */
	private $created = '';

	/**
	 * @var UserStrategy
	 */
	private $strategyUser;

	/**
	 * @var array
	 */
	private $errors = [];

	/**
	 * @var User
	 */
	private static $instanceCurrent;

	/**
	 * @var User
	 */
	private static $instanceCreate;

	/**
	 * @return User
	 * @throws \Exception\FileException
	 */
	public static function current(): self
	{
		if (!self::$instanceCurrent instanceof User) {
			self::$instanceCurrent = new static();
			self::$instanceCurrent->isAuth();
		}

		return self::$instanceCurrent;
	}

	/**
	 * @return User
	 */
	public static function create(): self
	{
		if (!self::$instanceCreate instanceof User) {
			self::$instanceCreate = new static();
		}

		return self::$instanceCreate;
	}

	/**
	 * User constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * @return UserStrategy
	 */
	public function getStrategyUser(): UserStrategy
	{
		if (!$this->strategyUser instanceof UserStrategy) {
			$this->strategyUser = new UserStrategy();
		}

		return $this->strategyUser;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

	/**
	 * @param string $created
	 * @return User
	 */
	public function setCreated(string $created): self
	{
		$this->created = $created;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCreated(): string
	{
		return $this->created;
	}

	/**
	 * @return string
	 */
	public function getUserId(): string
	{
		return $this->userId;
	}

	/**
	 * @param string $login
	 * @return User
	 */
	public function setLogin(string $login): self
	{
		$this->login = $login;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLogin(): string
	{
		return $this->login;
	}

	/**
	 * @param string $email
	 * @return User
	 */
	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $role
	 * @return User
	 */
	public function setRole(string $role): self
	{
		$this->role = $role;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRole(): string
	{
		return $this->role;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->login;
	}

	/**
	 * @param string $password
	 * @return User
	 * @throws \Exception\FileException
	 */
	public function setPassword(string $password): self
	{
		$this->password = \password_hash($password . Config::get('salt', 'passwordUser'), PASSWORD_DEFAULT);

		return $this;
	}

	/**
	 * @throws \Exception
	 */
	public function authentication(): void
	{
		$auth = Authentication::create()->processAuthentication($this, 1000);

		if ($auth->isAuth()) {
			FlashText::add(FlashText::MSG_SUCCESS, 'Вы успешно авторизовались на сайте!');

			$this->isLoaded = true;
			$this->isAuth   = true;
		}
	}

	/**
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function logout(): bool
	{
		$isLogout = Authentication::create()
			->processLogout()
			->isLogout();

		if ($isLogout) {
			$this->isLoaded = false;
			$this->isAuth   = false;
		}

		return $isLogout;
	}

	/**
	 * @param int $userId
	 * @throws \Exception
	 */
	public function loadByUserId(int $userId)
	{
		$user = $this
			->getStrategyUser()
			->loadByUserId($userId);

		if (empty($user)){
			$this->isLoaded = false;
			return;
		}

		$this->isLoaded = true;
		$this->setProperties($user);
	}

	/**
	 * @param string $login
	 * @throws \Exception
	 */
	public function loadByLogin(string $login)
	{
		$user = $this
			->getStrategyUser()
			->loadByLogin($login);

		if (empty($user)){
			$this->isLoaded = false;
			return;
		}

		$this->isLoaded = true;
		$this->setProperties($user);
	}

	/**
	 * @param string $email
	 * @throws \Exception
	 */
	public function loadByEmail(string $email)
	{
		$user = $this
			->getStrategyUser()
			->loadByLogin($email);

		if (empty($user)){
			$this->isLoaded = false;
			return;
		}

		$this->isLoaded = true;
		$this->setProperties($user);
	}

	/**
	 * @param AbstractValidator $form
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function loadByEmailOrLogin(AbstractValidator $form)
	{
		$user = $this
			->getStrategyUser()
			->loadByEmailOrLogin($form->getValueField('email'), $form->getValueField('login'));

		if (empty($user)){
			$this->errors[] = Util::getFormMessage(Validators::AUTH)['fail-auth-data'] ?? '';
			$this->isLoaded = false;
			return;
		}

		$authPassword = $form->getValueField('password') . Config::get('salt', 'passwordUser');

		if (!\password_verify($authPassword, $user['password'])) {
			$this->isLoaded = false;
			$this->errors[] = Util::getFormMessage(Validators::AUTH)['fail-auth-data'] ?? '';
			return;
		}

		$this->isLoaded = true;
		$this->setProperties($user);
	}

	/**
	 * @return bool
	 */
	public function isLoaded(): bool
	{
		return $this->isLoaded;
	}

	/**
	 * @return bool
	 * @throws \Exception\FileException
	 */
	public function isAuth(): bool
	{
		if ($this->isAuth) {
			return true;
		}


		Authorization::create()->verifyAccess();

		if (!Authorization::create()->isAccess()) {
			return false;
		}

		$this->isLoaded = true;
		$this->isAuth   = true;

		$this->setProperties(JWTokenManager::create()->decode()->toArray());

		return $this->isAuth;//SessionRedis::create()->get($JWTokenManager->getPartToken(JWTokenManager::SIGN_TOKEN));
	}

	/**
	 * @return bool
	 */
	public function isSaved(): bool
	{
		return $this->isSaved;
	}

	/**
	 * @param int $role
	 * @return bool
	 */
	public function isGranted(int $role): bool
	{
		return $this->role & $role;
	}

	/**
	 * @return User
	 * @throws \Exception\FileException
	 * @throws \Exception
	 */
	public function createUser(): User
	{
		$user = $this->getStrategyUser()->loadByEmailOrLogin($this->email, $this->login);

		if (!empty($user)) {
			$this->errors[] = Util::getFormMessage(Validators::REGISTER)['user-exist'] ?? '';
			return $this;
		}

		$this->isSaved = $this->getStrategyUser()->createUser([
			'password' => $this->password,
			'email'    => $this->email,
			'login'    => $this->login,
		]);

		if (!$this->isSaved) {
			$this->errors[] = Util::getFormMessage(Validators::COMMON)['error-save'] ?? '';
		}

		return $this;
	}

	/**
	 * @param array $props
	 */
	public function setProperties(array $props)
	{
		$this->login    = $props['login'];
		$this->email    = $props['email'];
		$this->role     = $props['role'];
		$this->password = $props['password'] ?? '';
		$this->created  = $props['created'];
		$this->userId   = $props['userId'];
	}
}
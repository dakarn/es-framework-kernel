<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.09.2018
 * Time: 1:21
 */

namespace ES\Kernel\Models\User;

use ES\Kernel\Configs\Config;
use ES\Kernel\Helper\FlashText;
use ES\Kernel\System\Auth\Authentication\Authentication;
use ES\Kernel\System\Auth\Authorization\Authorization;
use ES\Kernel\System\Auth\JWTokenManager;
use ES\Kernel\Helper\Util;
use ES\Kernel\System\Validators\AbstractValidator;
use ES\Kernel\System\Validators\Validators;

class User implements UserInterface
{
	public const ROLE_ADMIN = 0b000001; //64
	public const ROLE_USER  = 0b000001; //1
	public const ROLE_MODER = 0b000100; //2
	public const ROLE_ANON  = 0b000000; //0

	/**
	 * @var bool
	 */
	private $wasCheckAuth = false;

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
	 * @throws \ES\Kernel\Exception\FileException
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
	 * @throws \ES\Kernel\Exception\FileException
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
		$auth = Authentication::create()->processAuthentication($this);

		if ($auth->isAuth()) {
			FlashText::add(FlashText::MSG_SUCCESS, 'Вы успешно авторизовались на сайте!');

			$this->isLoaded = true;
			$this->isAuth   = true;
		}
	}

	/**
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
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
	 * @return bool
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function logoutAllDevice(): bool
	{
		$isLogout = Authentication::create()
			->processLogoutAllDevice()
			->isLogout();

		if ($isLogout) {
			$this->isLoaded = false;
			$this->isAuth   = false;
		}

		return $isLogout;
	}

	/**
	 * @param int $userId
	 * @return UserInterface|null
	 */
	public static function loadByUserId(int $userId):? UserInterface
	{
		$userObject = new static();

		$user = $userObject
			->getStrategyUser()
			->loadByUserId($userId);

		if (empty($user)){
			$userObject->isLoaded = false;
			return null;
		}

		$userObject->isLoaded = true;
		$userObject->setProperties($user);

		return $userObject;
	}

	/**
	 * @param string $login
	 * @return UserInterface|null
	 */
	public static function loadByLogin(string $login):? UserInterface
	{
		$userObject = new static();

		$user = $userObject
			->getStrategyUser()
			->loadByLogin($login);

		if (empty($user)){
			$userObject->isLoaded = false;
			return null;
		}

		$userObject->isLoaded = true;
		$userObject->setProperties($user);

		return $userObject;
	}

	/**
	 * @param string $email
	 * @return UserInterface
	 */
	public static function loadByEmail(string $email):? UserInterface
	{
		$userObject = new static();

		$user = $userObject
			->getStrategyUser()
			->loadByLogin($email);

		if (empty($user)){
			$userObject->isLoaded = false;
			return null;
		}

		$userObject->isLoaded = true;
		$userObject->setProperties($user);

		return $userObject;
	}

	/**
	 * @param AbstractValidator $form
	 * @return UserInterface|null
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public static function loadByEmailOrLogin(AbstractValidator $form):? UserInterface
	{
		$userObject = new static();

		$user = $userObject
			->getStrategyUser()
			->loadByEmailOrLogin($form->getValueField('email'), $form->getValueField('login'));

		if (empty($user)){
			$userObject->errors[] = Util::getFormMessage(Validators::AUTH)['fail-auth-data'] ?? '';
			$userObject->isLoaded = false;
			return null;
		}

		$authPassword = $form->getValueField('password') . Config::get('salt', 'passwordUser');

		if (!\password_verify($authPassword, $user['password'])) {
			$userObject->isLoaded = false;
			$userObject->errors[] = Util::getFormMessage(Validators::AUTH)['fail-auth-data'] ?? '';
			return null;
		}

		$userObject->isLoaded = true;
		$userObject->setProperties($user);

		return $userObject;
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
	 * @throws \ES\Kernel\Exception\FileException
	 */
	public function isAuth(): bool
	{
		if ($this->wasCheckAuth) {
			return $this->isAuth;
		}

		$this->wasCheckAuth = true;

		Authorization::create()->verifyAccess();

		if (!Authorization::create()->isAccess()) {
			return false;
		}

		$this->isLoaded = true;
		$this->isAuth   = true;

		$this->setProperties(JWTokenManager::create()->decode()->toArray());

		return $this->isAuth;
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
		return Authorization::create()->isGranted($role, $this->role);
	}

	/**
	 * @return User
	 * @throws \ES\Kernel\Exception\FileException
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
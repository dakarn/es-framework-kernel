<?php

namespace ES\Kernel\UserManager;

use ES\Kernel\Auth\Authentication\Authentication;
use ES\Kernel\Auth\Authorization\Authorization;
use ES\Kernel\Auth\JWTokenManager;
use ES\Kernel\Exception\FileException;
use ES\Kernel\Exception\ObjectException;
use ES\Kernel\Helper\RepositoryHelper\RepositoryInterface;
use ES\Kernel\Helper\RepositoryHelper\StorageRepository;

class UserManager
{
    /**
     * @var RepositoryInterface|UserRepository
     */
    private $repository;

    /**
     * @var User
     */
    private $current;

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
    private $isLogout = false;

    /**
     * @var self
     */
    private static $userManager;

    /**
     * UserManager constructor.
     */
    private function __construct()
    {
        $this->repository = StorageRepository::getUserRepository();
    }

    /**
     * @return UserManager
     * @throws FileException
     * @throws ObjectException
     */
    public static function create(): UserManager
    {
        if (!self::$userManager instanceof UserManager) {
            self::$userManager = new static();
            self::$userManager->isAuth();
        }

        return self::$userManager;
    }

    /**
     * @param User $current
     * @return UserManager
     */
    public function setCurrent(User $current): UserManager
    {
        $this->current = $current;

        return $this;
    }

    /**
     * @return User
     */
    public function getCurrentUser(): ?User
    {
        return $this->current;
    }

    /**
     * @throws FileException
     */
    public function createUser(): ?User
    {
        $result = $this->repository->createUser($this->getCurrentUser());

        if (!$this->repository->isSaved()) {
            return null;
        }

        return $result;
    }

    /**
     * @throws FileException
     */
    public function authentication(): void
    {
        if (Authentication::create()->processAuthentication($this->getCurrentUser())->isAuth()) {
            $this->isAuth   = true;
        }
    }

    /**
     * @return void
     * @throws FileException
     */
    public function logout(): void
    {
        if (Authentication::create()->processLogout()->isLogout()) {
            $this->isAuth   = false;
            $this->isLogout = true;
        }
    }

    /**
     * @throws FileException
     */
    public function logoutAllDevice(): void
    {
        if (Authentication::create()->processLogoutAllDevice()->isLogout()) {
            $this->isAuth   = false;
            $this->isLogout = true;
        }
    }

    /**
     * @param int $userId
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByUserId(int $userId): ?User
    {
        return $this->repository->loadByUserId($userId);
    }

    /**
     * @param string $login
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByLogin(string $login): ?User
    {
        return $this->repository->loadByLogin($login);
    }

    /**
     * @param string $email
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByEmail(string $email): ?User
    {
        return $this->repository->loadByEmail($email);
    }

    /**
     * @param string $email
     * @param string $login
     * @return User|null
     * @throws FileException
     * @throws ObjectException
     */
    public function loadByEmailOrLogin(string $email, string $login): ?User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setLogin($login);

        return $this->repository->loadByEmailOrLogin($user);
    }

    /**
     * @return bool
     * @throws FileException
     * @throws ObjectException
     */
    public function isAuth(): bool
    {
        if ($this->wasCheckAuth) {
            return $this->isAuth;
        }

        $this->wasCheckAuth = true;

        if (Authorization::create()->verifyAccess()->isAccess()) {
            $this->current = JWTokenManager::create()->decode();
            $this->isAuth  = true;
        }


        return $this->isAuth;
    }

    /**
     * @return bool
     */
    public function isLogout(): bool
    {
        return $this->isLogout;
    }

    /**
     * @param int $role
     * @param User|null $user
     * @return bool
     */
    public function isGranted(int $role, User $user = null): bool
    {
        return Authorization::create()->isGranted($role, $user ?? $this->current);
    }
}
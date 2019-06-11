<?php

namespace ES\Kernel\UserManager;

use ES\Kernel\Configs\Config;
use ES\Kernel\ObjectMapper\ClassToMappingInterface;

class User implements ClassToMappingInterface, UserInterface
{
    public const ROLE_ADMIN = 0b000001; //64
    public const ROLE_USER  = 0b000001; //1
    public const ROLE_MODER = 0b000100; //2
    public const ROLE_ANON  = 0b000000; //0

    private $userId   = 0;
    private $login    = '';
    private $password = '';
    private $email    = '';
    private $role     = 0;
    private $created  = '';

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'userId',
            'login',
            'password',
            'email',
            'role',
            'created',
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return User
     */
    public function setUserId(int $userId): User
    {
        $this->userId = $userId;

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
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     * @throws \ES\Kernel\Exception\FileException
     */
    public function setPassword(string $password): User
    {
        $this->password = \password_hash($password . Config::get('salt', 'passwordUser'), PASSWORD_DEFAULT);

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
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @return User
     */
    public function setRole(int $role): User
    {
        $this->role = $role;

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
     * @param string $created
     * @return User
     */
    public function setCreated(string $created): User
    {
        $this->created = $created;

        return $this;
    }
}
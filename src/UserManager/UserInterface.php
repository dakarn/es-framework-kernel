<?php

namespace ES\Kernel\UserManager;

interface UserInterface
{
    /**
     * @return array
     */
    public function getProperties(): array;

    /**
     * @return int
     */
    public function getUserId(): int;

    /**
     * @param int $userId
     * @return User
     */
    public function setUserId(int $userId): User;

    /**
     * @return string
     */
    public function getLogin(): string;

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     * @return User
     * @throws \ES\Kernel\Exception\FileException
     */
    public function setPassword(string $password): User;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User;

    /**
     * @return int
     */
    public function getRole(): int;

    /**
     * @param int $role
     * @return User
     */
    public function setRole(int $role): User;

    /**
     * @return string
     */
    public function getCreated(): string;

    /**
     * @param string $created
     * @return User
     */
    public function setCreated(string $created): User;
}
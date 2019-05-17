<?php

namespace Helper;

class CSRFToken
{
    /**
    * @var string
    */
    private $token = '';

    /**
    * @var string
    */
    private $algo = 'md5';

    /**
     * CSRFToken constructor.
     */
     public function __construct()
     {
     }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getAlgo(): string
    {
        return $this->algo;
    }

    /**
     * @param string $token
     * @return CSRFToken
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param string $algo
     * @return CSRFToken
     */
    public function setAlgo(string $algo): self
    {
        $this->algo = $algo;
        return $this;
    }

}
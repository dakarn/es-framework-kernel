<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 22:13
 */

namespace ElasticSearch\Response;

class AbstractResponse
{
	protected $response = [];

    /**
     * AbstractResponse constructor.
     * @param string $response
     */
	public function __construct(string $response)
	{
		$this->response = json_decode($response, true);
	}

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function getTimedOut():? bool
    {
        return $this->response['timed_out'] ?? false;
    }

    /**
     * @return int
     */
    public function getTook():? int
    {
        return $this->response['took'] ?? 0;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->response['status'] ?? '';
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        if (!isset($this->response['error'])) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isFailure(): bool
    {
        if (isset($this->response['error'])) {
            return true;
        }

        return false;
    }
}
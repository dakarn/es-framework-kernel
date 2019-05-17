<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 20:39
 */

namespace ElasticSearch\Response;

final class ExecuteResponse extends AbstractResponse
{
    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->response['_version'] ?? 0;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->response['result'] ?? '';
    }
}
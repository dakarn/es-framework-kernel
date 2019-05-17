<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.12.2018
 * Time: 18:45
 */

namespace ElasticSearch\Response;

use ObjectMapper\ClassToMappingInterface;

class ErrorResponse extends AbstractResponse implements ClassToMappingInterface
{
    private $error;
    private $type;
    private $reason;

    public function getProperties(): array
    {
        return [
            'error',
            'type',
            'reason',
        ];
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason): void
    {
        $this->reason = $reason;
    }
}
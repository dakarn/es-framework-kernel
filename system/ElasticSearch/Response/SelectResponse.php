<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 20:39
 */

namespace ElasticSearch\Response;

use ObjectMapper\ClassToMappingInterface;
use ObjectMapper\ObjectMapper;

final class SelectResponse extends AbstractResponse implements ClassToMappingInterface
{
    private $index;
    private $type;
    private $id;
    private $version;
    private $seqNo;
    private $primaryTerm;
    private $found;
    private $source;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'index',
            'type',
            'id',
            'version',
            'seqNo',
            'primaryTerm',
            'found',
            'source',
        ];
    }

    /**
     * SelectResult constructor.
     * @param string $response
     * @throws \Exception\ObjectException
     */
    public function __construct(string $response)
    {
        parent::__construct($response);
        ObjectMapper::create()->arrayToObject($this->response, $this);
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param mixed $index
     */
    public function setIndex($index): void
    {
        $this->index = $index;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version): void
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getSeqNo()
    {
        return $this->seqNo;
    }

    /**
     * @param mixed $seqNo
     */
    public function setSeqNo($seqNo): void
    {
        $this->seqNo = $seqNo;
    }

    /**
     * @return mixed
     */
    public function getPrimaryTerm()
    {
        return $this->primaryTerm;
    }

    /**
     * @param mixed $primaryTerm
     */
    public function setPrimaryTerm($primaryTerm): void
    {
        $this->primaryTerm = $primaryTerm;
    }

    /**
     * @return mixed
     */
    public function getFound()
    {
        return $this->found;
    }

    /**
     * @param mixed $found
     */
    public function setFound($found): void
    {
        $this->found = $found;
    }

    /**
     * @return array
     */
    public function getSource(): array
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    public function isFound(): bool
    {
        return (bool) $this->found;
    }


}
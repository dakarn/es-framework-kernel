<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 11:32
 */

namespace ES\Kernel\ElasticSearch;

use ES\Kernel\ObjectMapper\ClassToMappingInterface;

/**
 * Class ElasticConnect
 * @package ElasticSearch
 */
class ElasticConnection implements ClassToMappingInterface
{
    /**
     * @var string
     */
    private $schema = '';

    /**
     * @var string
     */
    private $host = '';

    /**
     * @var string
     */
    private $port = '';

	/**
	 * @return array
	 */
    public function getProperties(): array
    {
    	return [
    		'schema',
		    'host',
		    'port'
	    ];
    }

	/**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }

    /**
     * @param string $schema
     */
    public function setSchema(string $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     */
    public function setPort(string $port)
    {
        $this->port = $port;
    }
}
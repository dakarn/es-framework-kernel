<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.2018
 * Time: 20:14
 */

namespace ElasticSearchNew;

use ElasticSearchNew\QueryTypes\QueryTypesInterface;
use Traits\SingletonTrait;

class ElasticSearchNew
{
	use SingletonTrait;

    /**
     * @var array
     */
    private $queryParamsObject = [];

    /**
     * @var AbstractElasticQueryParams
     */
	private $currentQueryClass;

    /**
     * @return AbstractElasticQueryParams
     */
    public function select(): AbstractElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::SELECT);
    }

    /**
     * @return AbstractElasticQueryParams
     */
    public function update(): AbstractElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::UPDATE);
    }

    /**
     * @return AbstractElasticQueryParams
     */
    public function remove(): AbstractElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::REMOVE);
    }

    /**
     * @return AbstractElasticQueryParams
     */
    public function insert(): AbstractElasticQueryParams
    {
        return $this->getQueryClass(QueryTypesInterface::INSERT);
    }

    /**
     * @return AbstractElasticQueryParams
     */
    public function getCurrentQueryType(): AbstractElasticQueryParams
    {
        return $this->currentQueryClass;
    }

    /**
     * @param string $queryClass
     * @return mixed
     */
    private function getQueryClass(string $queryClass)
    {
        if (!$this->queryParamsObject[$queryClass] instanceof $queryClass) {
            $this->queryParamsObject[$queryClass] = new $queryClass();
        }

        return $this->queryParamsObject[$queryClass];
    }
}
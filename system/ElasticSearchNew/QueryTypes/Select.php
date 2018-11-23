<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:44
 */

namespace ElasticSearchNew\QueryTypes;

use ElasticSearchNew\AbstractElasticQueryParams;

class Select extends AbstractElasticQueryParams
{
    public function buildParams()
    {

    }

    public function getRecords(): array
    {
        return [];
    }

    public function getRecordsAsObject($objectList, $object)
    {

    }
}
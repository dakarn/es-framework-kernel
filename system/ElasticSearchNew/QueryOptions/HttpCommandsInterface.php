<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 26.11.2018
 * Time: 17:42
 */

namespace ElasticSearchNew\QueryOptions;

interface HttpCommandsInterface
{
    public const BULK    = '_bulk';
    public const SEARCH  = '_search';
    public const REINDEX = '_reindex';
}
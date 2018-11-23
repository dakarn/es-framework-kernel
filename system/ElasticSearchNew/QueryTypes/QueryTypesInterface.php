<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:57
 */

namespace ElasticSearchNew\QueryTypes;

interface QueryTypesInterface
{
    public const SELECT = Select::class;
    public const UPDATE = Update::class;
    public const REMOVE = Remove::class;
    public const INSERT = Insert::class;
}
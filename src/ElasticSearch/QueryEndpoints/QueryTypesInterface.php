<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:57
 */

namespace ES\Kernel\ElasticSearch\QueryEndpoints;

interface QueryTypesInterface
{
    public const SELECT = Select::class;
    public const UPDATE = Update::class;
    public const REMOVE = Remove::class;
    public const INSERT = Insert::class;
    public const INDEX  = Index::class;
    public const SEARCH = Search::class;
    public const BULK   = Bulk::class;
    public const SQL    = Sql::class;
}
<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:52
 */

require_once '../vendor/autoload.php';

use ElasticSearch\ElasticSearch;
use ElasticSearch\ElasticQuery;

class ElasticTests
{
    public static function testSelect()
    {
        $es = ElasticSearch::create()
            ->select()
            ->setIndex('twitter')
            ->setType('_doc')
            ->setId('1');

        print_r(ElasticQuery::create()->execute($es));
    }

    public static function testInsert()
    {
        $es = ElasticSearch::create()
            ->insert()
            ->setIndex('twitter')
            ->setType('_doc');

        print_r(ElasticQuery::create()->execute($es));
    }

    public static function testCreateIndex()
    {
        $es = ElasticSearch::create()
            ->index()
            ->create()
            ->withMapping([
                'mappings' => [
                    'user' => [
                        'properties' => [
                            'title' => [
                                'type' => 'text'
                            ],
                        ]
                    ]
                ]
            ])
            ->setIndex('twitter');

        print_r(ElasticQuery::create()->execute($es));
    }

    public static function testUpdate()
    {
        ElasticSearch::create()
            ->insert()
            ->setIndex('test')
            ->setType('book')
            ->setId(1);
    }

    public static function testRemove()
    {
        $es = ElasticSearch::create()
            ->remove()
            ->setIndex('twitter')
            ->setType('_doc')
            ->setId('1');

        print_r(ElasticQuery::create()->execute($es));
    }

    public static function testSearch()
    {
        $es = ElasticSearch::create()
            ->search()
            ->setIndex('twitter')
            ->setQuery([
                'query' => [
                    'term' => [
                        'email' => 'Test'
                    ]
                ]
            ]);

        print_r(ElasticQuery::create()->execute($es));
    }

    public static function testBulk()
    {
        $data = [];

        for($i = 0; $i < 100000; $i++) {
            $data[] = [
                'index' => ['_index' => 'twitter', '_type' => 'user', '_id' => microtime(true) . $i]
            ];
            $data[] = [
                'title' => '' . microtime(true) . ''
            ];
        }

        $es = ElasticSearch::create()
            ->bulk()
            ->setBulkArray($data);

        print_r(ElasticQuery::create()->execute($es));
    }
}

ElasticTests::testBulk();
<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 15:52
 */

require_once '../vendor/autoload.php';

use ES\Kernel\ElasticSearch\ElasticSearch;
use ES\Kernel\ElasticSearch\ElasticQuery;

class Elastic1
{
	/**
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\HttpException
	 * @throws \ES\Kernel\Exception\ObjectException
	 */
    public static function testSelect()
    {
        $es = ElasticSearch::create()
            ->select()
            ->setIndex('logs')
            ->setType('errorLog')
            ->setId('Rq5onmoBB05uMRH5tr6i');

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
            ->setIndex('logs')
            ->setQuery([
                'query' => [
                    'term' => [
                        'level' => 'info'
                    ]
                ]
            ]);

        print_r(ElasticQuery::create()->execute($es));
    }

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\HttpException
	 * @throws \ES\Kernel\Exception\ObjectException
	 */
    public static function testBulk()
    {
        $data = [];

        for($i = 0; $i < 1; $i++) {
	        $data[] = [
		        'index' => [
			        '_index' => 'logs',
			        '_type'  => 'errorLog']
	        ];
	        $data[] = [
		        'level'   => 'info',
		        'time'    => date('d.m.y H:i:s'),
		        'message' => 'test',
	        ];
        }

        $es = ElasticSearch::create()
            ->bulk()
            ->setBulkArray($data);

        print_r(ElasticQuery::create()->execute($es));
    }
}

Elastic1::testSearch();
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 20:34
 */

require_once '../vendor/autoload.php';

use ES\Kernel\ElasticSearch\ElasticSearch;
use ES\Kernel\ElasticSearch\ElasticQuery;
use ES\Kernel\ElasticSearch\QueryEndpoints\Index;
use ES\Kernel\ElasticSearch\QueryEndpoints\Bulk;

class Elastic
{
	/**
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\HttpException
	 */
	public static function testCreateIndex()
	{
		/** @var Index $es */
		$es = ElasticSearch::create()
			->index()
			->setIndex('twitter');

		$es->withMapping([
				'mappings' => [
					'book' => [
						'properties' => [
							'word' => [
								'type' => 'text'
							],
						]
					]
				]
		])
		->create();

		print_r(ElasticQuery::create()->execute($es));
	}

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\HttpException
	 */
	public static function testBulk()
	{
		/** @var Bulk $es */
		$es = ElasticSearch::create()->bulk();

		$es->setBulkArray([
				'index' => [
					'_index' => 'twitter',
					'_type' => 'word'
				]
		]);

		print_r(ElasticQuery::create()->execute($es));
	}

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\HttpException
	 */
	public static function testSelect()
	{
		$es = ElasticSearch::create()
			->select()
			->setIndex('twitter')
			->setType('twitter')
			->setId(1);

		print_r(ElasticQuery::create()->execute($es));
	}
}


Elastic::testBulk();
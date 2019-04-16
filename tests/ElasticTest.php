<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.11.2018
 * Time: 20:34
 */

require_once '../vendor/autoload.php';

use ElasticSearch\ElasticSearch;
use ElasticSearch\ElasticQuery;
use ElasticSearch\QueryEndpoints\Index;
use ElasticSearch\QueryEndpoints\Bulk;

class ElasticTest
{
	/**
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
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
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
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
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
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


ElasticTest::testBulk();
<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 17:35
 */

namespace ES\Kernel\ElasticSearch;

use ES\Kernel\ElasticSearch\QueryOptions\ElasticQueryParams;
use ES\Kernel\ElasticSearch\QueryEndpoints\Bulk;
use ES\Kernel\ElasticSearch\QueryEndpoints\Index;
use ES\Kernel\ElasticSearch\QueryEndpoints\Insert;
use ES\Kernel\ElasticSearch\QueryEndpoints\Remove;
use ES\Kernel\ElasticSearch\QueryEndpoints\Select;
use ES\Kernel\ElasticSearch\QueryEndpoints\Update;

interface ElasticSearchInterface
{
	/**
	 * @return Bulk
	 */
	public function bulk(): Bulk;

	/**
	 * @return Select
	 */
	public function select(): Select;


	/**
	 * @return Index
	 */
	public function index(): Index;


	/**
	 * @return Update
	 */
	public function update(): Update;


	/**
	 * @return Remove
	 */
	public function remove(): Remove;


	/**
	 * @return Insert
	 */
	public function insert(): Insert;


	/**
	 * @return ElasticQueryParams
	 */
	public function getCurrentQueryType(): ElasticQueryParams;
}
<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 17:35
 */

namespace ElasticSearch;

use ElasticSearch\QueryEndpoints\BuilderQueryInterface;
use ElasticSearch\QueryOptions\ElasticQueryParams;
use ElasticSearch\QueryEndpoints\Bulk;
use ElasticSearch\QueryEndpoints\Index;
use ElasticSearch\QueryEndpoints\Insert;
use ElasticSearch\QueryEndpoints\Remove;
use ElasticSearch\QueryEndpoints\Select;
use ElasticSearch\QueryEndpoints\Update;

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
<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 17:35
 */

namespace ElasticSearchNew;

use ElasticSearchNew\QueryOptions\ElasticQueryParams;
use ElasticSearchNew\QueryTypes\Bulk;
use ElasticSearchNew\QueryTypes\Index;
use ElasticSearchNew\QueryTypes\Insert;
use ElasticSearchNew\QueryTypes\Remove;
use ElasticSearchNew\QueryTypes\Select;
use ElasticSearchNew\QueryTypes\Update;

interface ElasticSearchNewInterface
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
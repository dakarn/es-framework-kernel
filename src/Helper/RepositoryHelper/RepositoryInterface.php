<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:38
 */

namespace ES\Kernel\Helper\RepositoryHelper;

interface RepositoryInterface
{
	/**
	 * @return bool
	 */
	public function isEmptyResult(): bool;

	/**
	 * @return bool
	 */
	public function isLoaded(): bool;

	/**
	 * @return bool
	 */
	public function isSaved(): bool;

	/**
	 * @return mixed
	 */
	public function getResult();
}
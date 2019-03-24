<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:22
 */

namespace Helper\RepositoryHelper;

class AbstractRepository implements RepositoryInterface
{
	/**
	 * @var
	 */
	protected $resultOperation;

	/**
	 * @var bool
	 */
	protected $isLoaded = false;

	/**
	 * @var bool
	 */
	protected $isSaved = false;

	/**
	 * @return bool
	 */
	public function isEmptyResult(): bool
	{
		return empty($this->resultOperation);
	}

	/**
	 * @return bool
	 */
	public function isLoaded(): bool
	{
		return $this->isLoaded;
	}

	/**
	 * @return bool
	 */
	public function isSaved(): bool
	{
		return $this->isSaved;
	}
}
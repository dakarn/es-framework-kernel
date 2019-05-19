<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.03.2019
 * Time: 22:22
 */

namespace ES\Kernel\Helper\RepositoryHelper;

class AbstractRepository implements RepositoryInterface
{
	/**
	 * @var mixed
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
	 * @var mixed
	 */
	protected $storage;

	/**
	 * @return mixed
	 */
	public function getResult()
	{
		return $this->resultOperation;
	}

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
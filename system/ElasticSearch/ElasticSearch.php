<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10.03.2018
 * Time: 20:14
 */

namespace ElasticSearch;

use Traits\SingletonTrait;

class ElasticSearch
{
	use SingletonTrait;

	/**
	 * @var
	 */
	private $strategy;

	/**
	 * @return ElasticQuery
	 */
	private function getStrategy(): ElasticQuery
	{
		if (!$this->strategy instanceof ElasticQuery) {
			$this->strategy = new ElasticQuery(new ElasticHttp());
		}

		return $this->strategy;
	}

	/**
	 * @param string $method
	 * @param $body
	 * @return ElasticSearch
	 */
	public function setBody(string $method, $body): self
	{
		$this->getStrategy()->setBody($method, $body);
		return $this;
	}

	/**
	 * @param string $index
	 * @return ElasticSearch
	 */
	public function setIndex(string $index): self
	{
		$this->getStrategy()->setIndex($index);
		return $this;
	}

	/**
	 * @param string $type
	 * @return ElasticSearch
	 */
	public function setType(string $type): self
	{
		$this->getStrategy()->setType($type);
		return $this;
	}

	/**
	 * @param string $id
	 * @return ElasticSearch
	 */
	public function setId(string $id): self
	{
		$this->getStrategy()->setType($id);
		return $this;
	}

	/**
	 * @param string $path
	 * @return ElasticSearch
	 */
	public function setPath(string $path): self
	{
		$this->getStrategy()->setPath($path);
		return $this;
	}

	/**
	 * @param array $body
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function search(array $body): ElasticResult
	{
		return $this->getStrategy()->search($body);
	}

	/**
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function createIndex(): ElasticResult
	{
		return $this->getStrategy()->createIndex();
	}

	/**
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function deleteIndex(): ElasticResult
	{
		return $this->getStrategy()->deleteIndex();
	}

	/**
	 *
	 */
	public function update()
	{
		$this->getStrategy()->update();
	}

	/**
	 * @param string $id
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function delete(string $id): ElasticResult
	{
		return $this->getStrategy()->delete($id);
	}

	/**
	 * @param array $body
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function add(array $body): ElasticResult
	{
		return $this->getStrategy()->add($body);
	}

	/**
	 * @param string $id
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function get(string $id = ''): ElasticResult
	{
		return $this->getStrategy()->get($id);
	}

	/**
	 * @param int $size
	 * @param int $from
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function getRecords(int $size, int $from): ElasticResult
	{
		return $this->getStrategy()->getRecords($size, $from);
	}

	/**
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function execute(): ElasticResult
	{
		return $this->getStrategy()->execute();
	}

}
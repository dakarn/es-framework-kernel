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

	private $strategy;

	private function getStrategy(): ElasticQuery
	{
		if (!$this->strategy instanceof ElasticQuery) {
			$this->strategy = new ElasticQuery(new ElasticHttp());
		}

		return $this->strategy;
	}

	public function setBody(string $method, $body): self
	{
		$this->getStrategy()->setBody($method, $body);
		return $this;
	}

	public function setIndex(string $index): self
	{
		$this->getStrategy()->setIndex($index);
		return $this;
	}

	public function setType(string $type): self
	{
		$this->getStrategy()->setType($type);
		return $this;
	}

	public function setId(string $id): self
	{
		$this->getStrategy()->setType($id);
		return $this;
	}

	public function setPath(string $path): self
	{
		$this->getStrategy()->setPath($path);
		return $this;
	}

	public function search(array $body): ElasticResult
	{
		return $this->getStrategy()->search($body);
	}

	public function createIndex(): ElasticResult
	{
		return $this->getStrategy()->createIndex();
	}

	public function deleteIndex(): ElasticResult
	{
		return $this->getStrategy()->deleteIndex();
	}

	public function update()
	{
		$this->getStrategy()->update();
	}

	public function delete(string $id): ElasticResult
	{
		return $this->getStrategy()->delete($id);
	}

	public function add(array $body): ElasticResult
	{
		return $this->getStrategy()->add($body);
	}

	public function get(string $id = ''): ElasticResult
	{
		return $this->getStrategy()->get($id);
	}

	public function execute(): ElasticResult
	{
		return $this->getStrategy()->execute();
	}

}
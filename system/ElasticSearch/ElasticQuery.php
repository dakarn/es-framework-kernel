<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2018
 * Time: 0:57
 */

namespace ElasticSearch;

class ElasticQuery
{
	/**
	 * @var ElasticHttp
	 */
	private $elasticHttp;

	/**
	 * @var
	 */
	private $index;

	/**
	 * @var
	 */
	private $type;

	/**
	 * @var
	 */
	private $id;

	/**
	 * @var array
	 */
	private $body = [];

	/**
	 * @var
	 */
	private $path;

	/**
	 * ElasticQuery constructor.
	 * @param ElasticHttp $elasticHttp
	 */
	public function __construct(ElasticHttp $elasticHttp)
	{
		$this->elasticHttp = $elasticHttp;
	}

	/**
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function execute(): ElasticResult
	{
		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
	}

	/**
	 * @param array $body
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function search(array $body): ElasticResult
	{
		if (empty($body)) {
			throw new \InvalidArgumentException('Body empty!');
		}

		$this->elasticHttp->setSearch();
		$this->body = $body;

		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
	}

	/**
	 * @param string $method
	 * @param $body
	 * @return ElasticQuery
	 */
	public function setBody(string $method, $body): self
	{
		if (!isset(ElasticHttp::ALLOW_METHOD[$method])) {
			throw new \InvalidArgumentException('No allow method!');
		}

		$method = 'set' . \strtoupper($method);
		$this->body = $body;
		$this->elasticHttp->$method();

		return $this;
	}

	/**
	 * @param string $index
	 * @return ElasticQuery
	 */
	public function setIndex(string $index): self
	{
		$this->index = $index;
		return $this;
	}

	/**
	 * @param string $id
	 * @return ElasticQuery
	 */
	public function setId(string $id): self
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $type
	 * @return ElasticQuery
	 */
	public function setType(string $type): self
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @param string $path
	 * @return ElasticQuery
	 */
	public function setPath(string $path): self
	{
		$this->path = $path;
		return $this;
	}

	/**
	 *
	 */
	public function update()
	{

	}

	/**
	 * @param string $id
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function delete(string $id): ElasticResult
	{
		$this->elasticHttp->setDELETE();
		$this->id = $id;

		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
	}

	/**
	 * @param array $body
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function add(array $body): ElasticResult
	{
		if (empty($body['id'])) {
			throw new \InvalidArgumentException('Param "id" must be integer!');
		}

		$this->elasticHttp->setPut();
		$this->id = $body['id'];
		unset($body['id']);
		$this->body = $body;

		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
	}

	/**
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function createIndex(): ElasticResult
	{
		$this->elasticHttp->setPUT();

		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
	}

	/**
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function deleteIndex(): ElasticResult
	{
		$this->elasticHttp->setDELETE();

		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
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
		$this->elasticHttp->setGET();
		$this->path = '_search/';

		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
	}

	/**
	 * @param string $id
	 * @return ElasticResult
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 */
	public function get(string $id): ElasticResult
	{
		$this->elasticHttp->setGET();

		if (empty($id) && empty($this->id)) {
			throw new \InvalidArgumentException('Param "id" must be integer!');
		}

		$this->id = $id;

		return $this->elasticHttp
			->setPretty(true)
			->query($this->buildQueryArray());
	}

	/**
	 * @return array
	 */
	private function buildQueryArray(): array
	{
		$param = [
			'index' => $this->index,
			'type'  => $this->type,
			'id'    => $this->id,
			'path'  => $this->path,
		];

		if (!empty($this->body)) {
			$param['body'] = $this->body;
		}

		return $param;
	}
}
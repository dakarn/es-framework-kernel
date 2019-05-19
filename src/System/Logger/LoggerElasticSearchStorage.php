<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2018
 * Time: 16:28
 */

namespace ES\Kernel\System\Logger;

use ES\Kernel\ElasticSearch\ElasticQuery;
use ES\Kernel\ElasticSearch\ElasticSearch;
use ES\Kernel\Traits\SingletonTrait;

class LoggerElasticSearchStorage extends AbstractLoggerStorage implements LoggerStorageInterface
{
	use SingletonTrait;

	/**
	 * @throws \ES\Kernel\Exception\FileException
	 * @throws \ES\Kernel\Exception\HttpException
	 */
	public function releaseLogs(): void
	{
		if (empty($this->logs)) {
			return;
		}

		$data = [];

		foreach ($this->logs as $log) {
			$data[] = [
				'index' => ['_index' => 'logs', '_type' => 'errorLog']
			];
			$data[] = [
				'level'   => \ucfirst($log['level']),
				'time'    => $log['time'],
				'message' => $log['message'],
			];
		}

		$es = ElasticSearch::create()
			->bulk()
			->setBulkArray($data);

		ElasticQuery::create()->execute($es);
	}
}
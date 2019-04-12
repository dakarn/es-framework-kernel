<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2018
 * Time: 16:28
 */

namespace System\Logger;

use ElasticSearchNew\ElasticQuery;
use ElasticSearchNew\ElasticSearchNew;
use Traits\SingletonTrait;

class LoggerElasticSearchStorage extends AbstractLoggerStorage implements LoggerStorageInterface
{
	use SingletonTrait;

	/**
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
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

		$es = ElasticSearchNew::create()
			->bulk()
			->setBulkArray($data);

		ElasticQuery::create()->execute($es);
	}
}
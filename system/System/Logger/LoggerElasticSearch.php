<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2018
 * Time: 16:28
 */

namespace System\Logger;

use ElasticSearch\ElasticSearch;
use Traits\SingletonTrait;

class LoggerElasticSearch implements LoggerStorageInterface
{
	use SingletonTrait;

	/**
	 * @var array
	 */
	private $logs = [];

	/**
	 * @param string $level
	 * @param string $message
	 * @return LoggerStorageInterface
	 */
	public function addLog(string $level, string $message): LoggerStorageInterface
	{
		$this->logs[] = [
			'time'    => date('d.m.y H:i:s', time()),
			'level'   => $level,
			'message' => $message
		];

		return $this;
	}

	/**
	 * @return array
	 */
	public function getLogs(): array
	{
		return $this->logs;
	}

	/**
	 *
	 */
	public function releaseLog(): void
	{
		if (empty($this->logs)) {
			return;
		}

		$data = '';

		foreach ($this->logs as $log) {
			$data .= \json_encode([
				'index' => [
					'_index' => 'logs',
					'_type' => 'errorLog'
				]
			]) . \PHP_EOL;

			$data .= \json_encode([
					'level'   => \ucfirst($log['level']),
					'time'    => $log['time'],
					'message' => $log['message'],
				], JSON_UNESCAPED_UNICODE) . \PHP_EOL;
		}

		ElasticSearch::create()
			->setPath('_bulk')
			->setBody('POST', $data)
			->execute();
	}
}
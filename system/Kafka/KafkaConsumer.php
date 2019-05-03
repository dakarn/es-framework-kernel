<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.05.2019
 * Time: 17:45
 */

namespace Kafka;

use RdKafka\Conf;
use RdKafka\Consumer;
use Configs\Config;
use RdKafka\ConsumerTopic;
use RdKafka\TopicConf;
use Kafka\Message\Payload;
use ObjectMapper\ObjectMapper;
use ElasticSearch\ElasticQuery;
use ElasticSearch\ElasticSearch;
use App\Models\Queue\Body\Logs;

class KafkaConsumer
{
	private $configureConnect;
	private $kafkaConf;
	private $rdKafkaConsumer;

	/**
	 * @var ConsumerTopic
	 */
	private $consumerTopic;

	/**
	 * KafkaConsumer constructor.
	 * @param ConfigureConnectInterface $configureConnect
	 * @throws \Exception\FileException
	 */
	public function __construct(ConfigureConnectInterface $configureConnect)
	{
		if (empty($configureConnect->getBrokers())) {
			throw new \RuntimeException('No brokers for connect');
		}

		$this->configureConnect = $configureConnect;
		$this->prepareObject();
	}

	/**
	 * @throws \Exception\FileException
	 * @throws \Exception\HttpException
	 * @throws \Exception\ObjectException
	 */
	public function waitMessage()
	{
		while (true) {

			$message = $this->consumerTopic->consume(0, 120*10000);
			$message = new RdKafkaMessage($message);

			if ($message->getErr() === RD_KAFKA_RESP_ERR_NO_ERROR) {

				/** @var Payload $payloadModel */
				$payloadModel = ObjectMapper::create()->arrayToObject($message->getPayloadAsArray(), new Payload(Logs::class));

				$data[] = [
					'index' => ['_index' => 'logs', '_type' => 'errorLog']
				];
				$data[] = [
					'level'   => \ucfirst($payloadModel->getBody()->getLevel()),
					'time'    => $payloadModel->getBody()->getTime(),
					'message' => $payloadModel->getBody()->getMessage(),
				];

				$es = ElasticSearch::create()
					->bulk()
					->setBulkArray($data);

				ElasticQuery::create()->execute($es);
			}
		}
	}

	/**
	 * @throws \Exception\FileException
	 */
	private function prepareObject()
	{
		$this->kafkaConf = new Conf();

		$this->kafkaConf->set('group.id', Groups::MY_CONSUMER_GROUP);

		$this->rdKafkaConsumer = new Consumer($this->kafkaConf);
		$this->rdKafkaConsumer->addBrokers(Config::get('kafka')['host']);

		$topicConf = new TopicConf();
		$topicConf->set('auto.commit.interval.ms', 100);

		$this->consumerTopic = $this->rdKafkaConsumer->newTopic(Topics::LOGS, $topicConf);
		$this->consumerTopic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
	}
}
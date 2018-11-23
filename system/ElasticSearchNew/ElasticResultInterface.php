<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 17:35
 */

namespace ElasticSearchNew;

interface ElasticResultInterface
{
    /**
     * @return array
     */
    public function getResult(): array;

    /**
     * @return array
     */
    public function getRecords(): array;

    /**
     * @param $objectList
     * @param $object
     */
    public function getRecordsAsObject($objectList, $object);

    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @return bool
     */
    public function isFailure(): bool;

    /**
     * @return array
     */
    public function getSource(): array;

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return array
     */
    public function getError(): array;
}
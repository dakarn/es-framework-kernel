<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.11.2018
 * Time: 17:35
 */

namespace ElasticSearchNew;

interface ElasticResultFactoryInterface
{
    /**
     * @return string
     */
    public function getResult(): string;

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
    public function getCountRecords(): int;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return array
     */
    public function getError(): array;
}
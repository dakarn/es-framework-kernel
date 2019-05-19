<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.04.2018
 * Time: 14:38
 */

namespace ES\Kernel\Http\Request;

interface UploadedFileInterface
{
    /**
     * @return StreamInterface
     */
    public function getStream(): StreamInterface;

    /**
     * @param $targetPath
     */
    public function moveTo($targetPath): void;

    /**
     * @return int
     */
    public function getSize(): int;

    /**
     * @return int
     */
    public function getError(): int;

    /**
     * @return mixed
     */
    public function getClientFilename(): string;

    /**
     * @return mixed
     */
    public function getClientMediaType(): string;
}
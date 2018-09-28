<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 23.04.2018
 * Time: 14:38
 */

namespace Http\Request;

class UploadedFile implements UploadedFileInterface
{
    /**
     * @return string
     */
    public function getClientFilename(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getClientMediaType(): string
    {
        return '';
    }

    /**
     * @return int
     */
    public function getError(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return 0;
    }

    /**
     * @return StreamInterface
     */
    public function getStream(): StreamInterface
    {
        return new Stream();
    }

    /**
     * @param $targetPath
     */
    public function moveTo($targetPath): void
    {
    }
}
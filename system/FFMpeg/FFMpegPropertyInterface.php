<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 17:32
 */

namespace FFMpeg;

interface FFMpegPropertyInterface
{
    public function setFile(string $file): FFMpegPropertyInterface;

    public function setSize(int $width, int $height): FFMpegPropertyInterface;

    public function setFormatType(string $type): FFMpegPropertyInterface;

    public function setOutputFile(string $file): FFMpegPropertyInterface;
}
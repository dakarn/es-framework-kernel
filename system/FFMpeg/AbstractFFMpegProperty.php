<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 15:20
 */

namespace FFMpeg;

abstract class AbstractFFMpegProperty implements FFMpegPropertyInterface
{
    protected $inputFile;

    protected $outputFile;

    protected $formatType;

    protected $size = [];

    public function setFile(string $file): FFMpegPropertyInterface
    {
        $this->inputFile = $file;
        return $this;
    }

    public function setSize(int $width, int $height): FFMpegPropertyInterface
    {
        $this->size = [
            'width'  => $width,
            'height' => $height
        ];

        return $this;
    }

    public function setFormatType(string $type): FFMpegPropertyInterface
    {
        $this->formatType = $type;
        return $this;
    }

    public function setOutputFile(string $file): FFMpegPropertyInterface
    {
        $this->outputFile = $file;
        return $this;
    }
}
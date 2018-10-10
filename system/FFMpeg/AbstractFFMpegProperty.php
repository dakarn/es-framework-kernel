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
	/**
	 * @var
	 */
	protected $inputFile;

	/**
	 * @var
	 */
	protected $outputFile;

	/**
	 * @var
	 */
	protected $formatType;

	/**
	 * @var array
	 */
	protected $size = [];

	/**
	 * @param string $file
	 * @return FFMpegPropertyInterface
	 */
	public function setFile(string $file): FFMpegPropertyInterface
    {
        $this->inputFile = $file;
        return $this;
    }

	/**
	 * @param int $width
	 * @param int $height
	 * @return FFMpegPropertyInterface
	 */
	public function setSize(int $width, int $height): FFMpegPropertyInterface
    {
        $this->size = [
            'width'  => $width,
            'height' => $height
        ];

        return $this;
    }

	/**
	 * @param string $type
	 * @return FFMpegPropertyInterface
	 */
	public function setFormatType(string $type): FFMpegPropertyInterface
    {
        $this->formatType = $type;
        return $this;
    }

	/**
	 * @param string $file
	 * @return FFMpegPropertyInterface
	 */
	public function setOutputFile(string $file): FFMpegPropertyInterface
    {
        $this->outputFile = $file;
        return $this;
    }
}
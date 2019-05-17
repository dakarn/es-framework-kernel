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
	/**
	 * @param string $file
	 * @return FFMpegPropertyInterface
	 */
	public function setFile(string $file): FFMpegPropertyInterface;

	/**
	 * @param int $width
	 * @param int $height
	 * @return FFMpegPropertyInterface
	 */
	public function setSize(int $width, int $height): FFMpegPropertyInterface;

	/**
	 * @param string $type
	 * @return FFMpegPropertyInterface
	 */
	public function setFormatType(string $type): FFMpegPropertyInterface;

	/**
	 * @param string $file
	 * @return FFMpegPropertyInterface
	 */
	public function setOutputFile(string $file): FFMpegPropertyInterface;
}
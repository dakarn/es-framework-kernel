<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:17
 */

namespace FFMpeg\Format;

use FFMpeg\FFMpeg;
use FFMpeg\FileFormatInterface;

class AVIFormat implements FileFormatInterface
{
	/**
	 * @var array
	 */
    private $data = [];

	/**
	 * AVIFormat constructor.
	 * @param array $data
	 */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

	/**
	 * @return mixed|void
	 */
    public function save()
    {
        \exec(FFMpeg::PATH_TO_FFMPEG . ' -i ' . $this->data['inputFile'] . ' ' . $this->data['outputFile']);
    }
}
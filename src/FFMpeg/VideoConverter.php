<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:09
 */

namespace ES\Kernel\FFMpeg;

use ES\Kernel\FFMpeg\Format\AVIFormat;
use ES\Kernel\FFMpeg\Format\FLVFormat;
use ES\Kernel\FFMpeg\Format\WEBMFormat;

class VideoConverter extends AbstractFFMpegProperty implements FFMpegPropertyInterface
{
	/**
	 * @var array
	 */
	private $data = [];

    /**
     * @var FileFormatInterface
     */
    private $formatter;

	/**
	 *
	 */
	public function save()
    {
        $this->validateParams();

        $this->formatter->save();
    }

	/**
	 *
	 */
	public function selectOutputFormat()
    {
        switch ($this->formatType) {
            case FFMpeg::TYPE_AVI:
                $this->formatter = new AVIFormat($this->data);
                break;
            case FFMpeg::TYPE_WEBM:
                $this->formatter = new WEBMFormat($this->data);
                break;
            case FFMpeg::TYPE_FLV:
                $this->formatter = new FLVFormat($this->data);
                break;
            default:
                throw new \DomainException('Such format no support for convertation!');
                break;
        }
    }

	/**
	 *
	 */
	private function validateParams()
    {
        switch (true) {
            case empty($this->inputFile):
                break;
            case empty($this->outputFile):
                break;
        }
    }
}
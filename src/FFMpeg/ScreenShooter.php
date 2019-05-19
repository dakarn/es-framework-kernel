<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:25
 */

namespace ES\Kernel\FFMpeg;

class ScreenShooter extends AbstractFFMpegProperty implements FFMpegPropertyInterface
{
	/**
	 * @var
	 */
	private $qualityImage;

	/**
	 * @var
	 */
	private $timeFromScreen;

	/**
	 * @param int $quality
	 * @return ScreenShooter
	 */
	public function setQuality(int $quality): ScreenShooter
    {
        $this->qualityImage = $quality;
        return $this;
    }

	/**
	 * @param string $time
	 * @return ScreenShooter
	 */
	public function setTimeScreen(string $time): ScreenShooter
    {
        $this->timeFromScreen = $time;
        return $this;
    }

	/**
	 *
	 */
	public function makeImage()
    {
        $this->validateParams();

        \exec(FFMpeg::PATH_TO_FFMPEG . ' -ss ' . $this->timeFromScreen . ' -i ' . $this->inputFile . ' -q:v ' . $this->qualityImage . ' ' . $this->outputFile);
    }

	/**
	 *
	 */
	private function validateParams()
    {
        switch (true) {
            case empty($this->timeFromScreen):
                break;
            case empty($this->qualityImage):
                break;
            case empty($this->inputFile):
                break;
            case empty($this->outputFile):
                break;
        }
    }
}
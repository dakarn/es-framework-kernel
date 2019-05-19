<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:08
 */

namespace ES\Kernel\FFMpeg;

use ES\Kernel\Traits\SingletonTrait;

class FFMpeg
{
    use SingletonTrait;

    const TYPE_WEBM = 'WEBM';

    const TYPE_AVI = 'AVI';

    const TYPE_FLV = 'FLV';

    const PATH_TO_FFMPEG = 'C:/Users/v.konovalov/Downloads/ffmpeg/ffmpeg.exe';

	/**
	 * @var
	 */
	private $converter;

	/**
	 * @var
	 */
	private $screenShoot;

	/**
	 * @var
	 */
	private $metaInfo;

	/**
	 * @return ScreenShooter
	 */
	public function ScreenShooter(): ScreenShooter
    {
        if (!$this->screenShoot instanceof ScreenShooter) {
            $this->screenShoot = new ScreenShooter();
        }

        return $this->screenShoot;
    }

	/**
	 * @return MetaInfo
	 */
	public function MetaInfo(): MetaInfo
    {
        if (!$this->metaInfo instanceof MetaInfo) {
            $this->metaInfo = new MetaInfo();
        }

        return $this->metaInfo;
    }

	/**
	 * @return VideoConverter
	 */
	public function Converter(): VideoConverter
    {
        if (!$this->converter instanceof VideoConverter) {
            $this->converter = new VideoConverter();
        }

        $this->converter->selectOutputFormat();

        return $this->converter;
    }
}
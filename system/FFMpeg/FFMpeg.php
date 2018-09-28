<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.05.2018
 * Time: 14:08
 */

namespace FFMpeg;

use Traits\SingletonTrait;

class FFMpeg
{
    use SingletonTrait;

    const TYPE_WEBM = 'WEBM';

    const TYPE_AVI = 'AVI';

    const TYPE_FLV = 'FLV';

    const PATH_TO_FFMPEG = 'C:/Users/v.konovalov/Downloads/ffmpeg/ffmpeg.exe';

    private $converter;

    private $screenShoot;

    private $metaInfo;

    public function ScreenShooter(): ScreenShooter
    {
        if (!$this->screenShoot instanceof ScreenShooter) {
            $this->screenShoot = new ScreenShooter();
        }

        return $this->screenShoot;
    }

    public function MetaInfo(): MetaInfo
    {
        if (!$this->metaInfo instanceof MetaInfo) {
            $this->metaInfo = new MetaInfo();
        }

        return $this->metaInfo;
    }

    public function Converter(): VideoConverter
    {
        if (!$this->converter instanceof VideoConverter) {
            $this->converter = new VideoConverter();
        }

        $this->converter->selectOutputFormat();

        return $this->converter;
    }
}
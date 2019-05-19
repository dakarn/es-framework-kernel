<?php
/**
 * Created by PhpStorm.
 * User: v.konovalov
 * Date: 28.04.2018
 * Time: 11:18
 */

namespace ES\Kernel\Http\Response;

class Serialize implements FormatResponseInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Json constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getFormattedText(): string
    {
        return \serialize($this->data);
    }
}
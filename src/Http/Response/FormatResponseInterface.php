<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 19:28
 */

namespace Http\Response;

interface FormatResponseInterface
{
    /**
     * @return string
     */
	public function getFormattedText(): string;
}
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 20:28
 */

namespace Http\Request;

interface RequestBuilderInterface
{
    public function __construct(RequestInterface $request);

    public function getBuilderData();
}
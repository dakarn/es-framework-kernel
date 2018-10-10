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
	/**
	 * RequestBuilderInterface constructor.
	 * @param RequestInterface $request
	 */
    public function __construct(RequestInterface $request);

	/**
	 * @return mixed
	 */
    public function getBuilderData();
}
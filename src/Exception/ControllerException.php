<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 31.03.2018
 * Time: 17:20
 */

namespace Exception;

/**
 * Class ControllerException
 * @package Exception
 */
class ControllerException extends HttpException
{
	/**
	 * @param array $arguments
	 * @return ControllerException
	 */
	public static function notFoundController(array $arguments = []): self
	{
		return new self('This controller "' . $arguments[0] . '" not found!');
	}

	/**
	 * @param array $arguments
	 * @return ControllerException
	 */
	public static function notFoundAction(array $arguments = []): self
	{
		return new self('This action "' . $arguments[0] . '" not found in this controller!');
	}

	/**
	 * @param array $arguments
	 * @return ControllerException
	 */
	public static function beforeReturnFalse(array $arguments = []): self
	{
		return new self('This before-method returned false!');
	}

	/**
	 * @param array $arguments
	 * @return ControllerException
	 */
	public static function deniedMethod(array $arguments = []): self
	{
		return new self('This method "' . $arguments[0] . '" forbidden on the URL!');
	}

	/**
	 * @param array $arguments
	 * @return ControllerException
	 */
	public static function invalidArguments(array $arguments = []): self
	{
		return new self('');
	}

	/**
	 * @param array $arguments
	 * @return ControllerException
	 */
	public static function beforeNoReturnBool(array $arguments = []): self
	{
		return new self('');
	}
}
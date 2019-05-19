<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.04.2018
 * Time: 20:49
 */

namespace ES\Kernel\Http\Request;

class Stream implements StreamInterface
{
	/**
	 *
	 */
	public function close()
	{

	}

	public function detach()
	{

	}

	public function tell(): void
	{

	}

	/**
	 * @return bool
	 */
	public function eof(): bool
	{
		return true;
	}

	/**
	 * @return int
	 */
	public function getSize(): int
	{
		return 0;
	}

	/**
	 * @return bool
	 */
	public function isSeekable(): bool
	{
		return true;
	}

	/**
	 * @return bool
	 */
	public function isReadable(): bool
	{
		return true;
	}

	public function rewind(): void
	{

	}

	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return '';
	}

	public function write(): void
	{

	}

	/**
	 * @return string
	 */
	public function read(): string
	{
		return '';
	}

	public function seek(string $offset, $whence = SEEK_SET): void
	{

	}

	/**
	 * @return string
	 */
	public function getMetadata(): string
	{
        return '';
	}
}
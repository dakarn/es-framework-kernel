<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.04.2018
 * Time: 20:49
 */

namespace Http\Request;

class Stream implements StreamInterface
{
	public function close(): void
	{

	}

	public function detach()
	{

	}

	public function tell(): void
	{

	}

	public function eof(): bool
	{
		return true;
	}

	public function getSize(): int
	{
		return 0;
	}

	public function isSeekable(): bool
	{
		return true;
	}

	public function isReadable(): bool
	{
		return true;
	}

	public function rewind(): void
	{

	}

	public function getContent(): string
	{
		return '';
	}

	public function write(): void
	{

	}

	public function read(): string
	{
		return '';
	}

	public function seek(string $offset, $whence = SEEK_SET): void
	{

	}

	public function getMetadata()
	{

	}
}
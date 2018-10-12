<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.10.2018
 * Time: 17:35
 */

namespace Helper;

class Mime
{
	public const
		EXT_BINARY  = '000',
		EXT_EXE     = 'exe',
		EXT_HTML    = 'html',
		EXT_XML     = 'xml',
		EXT_TXT     = 'txt',
		EXT_JSON    = 'json',
		EXT_CSS     = 'css',
		EXT_JS      = 'js',
		EXT_PDF     = 'pdf',
		EXT_RAR     = 'rar',
		EXT_JAR     = 'jar',
		EXT_7Z      = '7z',
		EXT_ZIP     = 'zip',
		EXT_DOC     = 'doc',
		EXT_RTF     = 'rtf',
		EXT_XLS     = 'xls',
		EXT_PPT     = 'ppt',
		EXT_CSV     = 'csv',
		EXT_GIF     = 'gif',
		EXT_JPG     = 'jpg',
		EXT_JPEG    = 'jpeg',
		EXT_PNG     = 'png',
		EXT_SVG     = 'svg',
		EXT_TIF     = 'tif',
		EXT_TIFF    = 'tiff',
		EXT_ICO     = 'ico',
		EXT_BMP     = 'bmp';

	public static function resolveByExt(string $ext): string
	{
		return '';
	}

	public static function resolve(string $ext): string
	{
		return '';
	}
}
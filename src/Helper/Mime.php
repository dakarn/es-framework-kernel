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
		BINARY  = 'application/octet-stream',
		EXE     = 'application/octet-stream',
		HTML    = 'text/html',
		XHTML   = 'application/xhtml+xml',
		XML     = 'text/xml',
		XML2    = 'application/xml',
		TEXT    = 'text/plain',
		RICH    = 'text/enriched',
		JSON    = 'application/json',
		ATOM    = 'application/atom+xml',
		CSS     = 'text/css',
		JS      = 'application/x-javascript',
		JS1     = 'text/javascript',
		JS2     = 'application/javascript',
		PDF     = 'application/pdf',
		RAR     = 'application/z-rar-compressed',
		JAR     = 'application/java-archive',
		_7Z     = 'application/z-7z-compressed',
		ZIP     = 'application/zip',
		DOC     = 'application/msword',
		RTF     = 'application/rtf',
		XLS     = 'application/vnd.ms-excel',
		PPT     = 'application/vnd.ms-powerpoint',
		CSV     = 'text/csv',
		GIF     = 'image/gif',
		JPG     = 'image/jpeg',
		JPGI    = 'image/pjpeg', //for ie
		PNG     = 'image/png',
		PNGI    = 'image/x-png', //for ie
		SVG     = 'image/svg+xml',
		TIFF    = 'image/tiff',
		ICO     = 'image/vnd.microsoft.icon',
		WBMP    = 'image/vnd.wap.wbmp',
		BMP     = 'image/x-ms-bmp';

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

	public const
		FORM_URL  = 'application/x-www-form-urlencoded',
		FORM_DATA = 'multipart/form-data',
		X_RFC2397 = 'text/x-rfc2397-encoded',
		MULTI_MIX = 'multipart/mixed',
		MULTI_PAR = 'multipart/parallel',
		MULTI_REL = 'multipart/related',
		MULTI_ALT = 'multipart/alternative';

	/**
	 * @param string $ext
	 * @return string
	 */
	public static function resolveByExt(string $ext): string
	{
		switch ($ext) {
			case self::EXT_BINARY:
				return self::BINARY;
			case self::EXT_BMP:
				return self::BMP;
			case self::EXT_JPEG:
			case self::EXT_JPG:
				return self::JPG;
			case self::EXT_PNG:
				return self::PNG;
			case self::EXT_GIF:
				return self::GIF;
			case self::EXT_PDF:
				return self::PDF;
			case self::EXT_TXT:
				return self::TEXT;
			case self::EXT_RTF:
				return self::RTF;
			case self::EXT_DOC:
				return self::DOC;
			case self::EXT_XLS:
				return self::XLS;
			case self::EXT_ZIP:
				return self::ZIP;
			case self::EXT_RAR:
				return self::RAR;
			case self::EXT_XML:
				return self::XML;
		}

		return self::BINARY;
	}

	public static function resolve(string $ext): string
	{
		return '';
	}
}
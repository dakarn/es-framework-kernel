<?php

namespace System\Database;

use System\EventListener\EventTypes;
use System\Registry;

class DB
{
    /**
     * @var \mysqli
     */
	private static $connect;

	/**
	 * @var DatabaseConfigure
	 */
	private static $configure;

    /**
     * DB constructor.
     */
	private function __construct()
	{
	}

    /**
     * @return void
     */
	private function __clone()
	{
	}

    /**
     * @param DatabaseConfigure $configure
     */
	public static function setConfigure(DatabaseConfigure $configure)
	{
		self::$configure = $configure;
	}

    /**
     * @return \mysqli
     */
	public static function create(): \mysqli
	{
		if (!self::$connect instanceof \mysqli) {
            $event = Registry::get(Registry::APP_EVENT);
		    $event->runEvent(EventTypes::BEFORE_DB_CONNECT);

			self::$connect = new \mysqli(
				self::$configure->getHost(),
				self::$configure->getUser(),
				self::$configure->getPassword(),
				self::$configure->getDatabase()
			);

			self::$connect->set_charset(self::$configure->getCharset());
            $event->runEvent(EventTypes::AFTER_DB_CONNECT);
		}

		return self::$connect;
	}

	/**
	 * @return bool
	 */
	public static function disconnect(): bool
	{
		if (self::$connect instanceof \mysqli) {
			mysqli_close(self::$connect);
			return true;
		}

		return false;
	}


}
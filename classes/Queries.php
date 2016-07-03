<?php

namespace skeletonmodule\classes;

if (!defined('_PS_VERSION_'))
    exit;

class Queries
{	
	private $db_prefix = _DB_PREFIX_;

	public static function getQueriesUp()
	{	
		return array(
				"CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."skeleton_listing`(
					`id_listing` INT(10) NOT NULL AUTO_INCREMENT,					
					PRIMARY KEY (id_listing)
				) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8",
				"CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."skeleton_listing_lang`(
					`id_listing` INT(10) NOT NULL AUTO_INCREMENT,
					`title_listing` VARCHAR(255) NOT NULL,
					`id_lang` INT NOT NULL,
					`id_shop` INT NOT NULL,
					PRIMARY KEY (id_listing)
				) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8",
				"CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."skeleton_listing_item`(
					`id_item` INT(10) NOT NULL AUTO_INCREMENT,
					`id_parent` INT(10) NOT NULL,
					PRIMARY KEY (id_item)
				) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8",
				"CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."skeleton_listing_item_lang`(
					`id_item` INT(10) NOT NULL AUTO_INCREMENT,
					`item_title` VARCHAR(255) NOT NULL,
					`item_link` VARCHAR(255) NOT NULL,
					`id_lang` INT NOT NULL,
					`id_shop` INT NOT NULL,
					PRIMARY KEY (id_item)
				) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8",
			);
	}
	
	public static function getQueriesDown()
	{	
		return array(
				"DROP TABLE IF EXISTS `"._DB_PREFIX_."skeleton_listing`",
				"DROP TABLE IF EXISTS `"._DB_PREFIX_."skeleton_listing_item`",
				"DROP TABLE IF EXISTS `"._DB_PREFIX_."skeleton_listing_lang`",
				"DROP TABLE IF EXISTS `"._DB_PREFIX_."skeleton_listing_item_lang`",
			);
	}
}
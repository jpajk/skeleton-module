<?php

namespace skeletonmodule\classes;

if (!defined('_PS_VERSION_'))
    exit;

class Queries
{	
	private $db_prefix = _DB_PREFIX_;

	public static function getQueriesUp()
		{	
			return array();
		}
	
		public static function getQueriesDown()
		{	
			return array();
		}

}
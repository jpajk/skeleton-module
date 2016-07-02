<?php

namespace skeletonmodule\classes\listing;

if (!defined('_PS_VERSION_'))
	exit;

use ObjectModel;

use skeletonmodule\traits\ModifiedObjectModel;

class Listing extends ObjectModel
{
    use ModifiedObjectModel;

	public $title_listing;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
    		'table' 		 => 'skeleton_listing',
    		'primary'		 => 'id_listing',
    		'multilang'		 => true,
    		'multilang_shop' => true,
    		'fields' => array(
    				'title_listing' => array(self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255)
    			)
    	);
}
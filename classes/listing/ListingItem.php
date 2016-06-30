<?php

namespace skeletonmodule\classes\listing;

if (!defined('_PS_VERSION_'))
	exit;

use ObjectModel;

class ListingItem extends ObjectModel
{
	public $title;
	public $id_parent;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
    		'table' 		 => 'skeleton_listing_item',
    		'primary'		 => 'id_listing',
    		'multilang'		 => true,
    		'multilang_shop' => true,
    		'fields' => array(
    				'title' 	=> array(self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
    				'id_parent' => array(self::TYPE_INT, 'validate' => 'isInt')
    			)
    	);
}
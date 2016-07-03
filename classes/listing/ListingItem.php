<?php

namespace skeletonmodule\classes\listing;

if (!defined('_PS_VERSION_'))
	exit;

use ObjectModel;

use skeletonmodule\traits\ModifiedObjectModel;

class ListingItem extends ObjectModel
{
    use ModifiedObjectModel;
    
	public $id_item;
	public $item_title;
    public $item_link;
    public $id_parent;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
    		'table' 		 => 'skeleton_listing_item',
    		'primary'		 => 'id_item',
    		'multilang'		 => true,
    		'multilang_shop' => true,
    		'fields' => array(
                    'id_item' => array(self::TYPE_INT, 'validate' => 'isInt'),
    				'item_title' 	=> array(self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255),
                    'item_link'    => array(self::TYPE_STRING, 'lang' => true, 'validate' => 'isUrl', 'size' => 255),
    				'id_parent' => array(self::TYPE_INT, 'validate' => 'isInt')
    			)
    	);
}
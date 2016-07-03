<?php

namespace skeletonmodule\classes\listing;

if (!defined('_PS_VERSION_'))
	exit;

use ObjectModel;

use skeletonmodule\traits\ModifiedObjectModel;

class Listing extends ObjectModel
{
    use ModifiedObjectModel;

	public $id_listing;
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
                    'id_listing' => array(self::TYPE_INT, 'validate' => 'isInt'),

    				'title_listing' => array(self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255)
    			)
    	);
}
<?php

namespace skeletonmodule\classes\listing;

if (!defined('_PS_VERSION_'))
	exit;

use Db;
use DbQuery;
use ObjectModel;
use Shop;
use stdClass;

use skeletonmodule\traits\ModifiedObjectModel;
use skeletonmodule\classes\listing\ListingItem;

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

    /**
     * Deletes current object from database
     *
     * @return bool True if delete was successful
     * @throws PrestaShopException
     */
    public function delete()
    {
        // @hook actionObject*DeleteBefore
        //Hook::exec('actionObjectDeleteBefore', array('object' => $this));
        //Hook::exec('actionObject'.get_class($this).'DeleteBefore', array('object' => $this));

        $this->clearCache();
        $result = true;
        // Remove association to multishop table
        if (Shop::isTableAssociated($this->def['table'])) {
            $id_shop_list = Shop::getContextListShopID();
            if (count($this->id_shop_list)) {
                $id_shop_list = $this->id_shop_list;
            }

            $result &= Db::getInstance()->delete($this->def['table'].'_shop', '`'.$this->def['primary'].'`='.(int)$this->id.' AND id_shop IN ('.implode(', ', $id_shop_list).')');
        }

        // Database deletion
        $has_multishop_entries = $this->hasMultishopEntries();
        if ($result && !$has_multishop_entries) {
            $result &= Db::getInstance()->delete($this->def['table'], '`'.bqSQL($this->def['primary']).'` = '.(int)$this->id);
        }

        if (!$result) {
            return false;
        }

        // Database deletion for multilingual fields related to the object
        if (!empty($this->def['multilang']) && !$has_multishop_entries) {
            $result &= Db::getInstance()->delete($this->def['table'].'_lang', '`'.bqSQL($this->def['primary']).'` = '.(int)$this->id);
        }

        // @hook actionObject*DeleteAfter
        //Hook::exec('actionObjectDeleteAfter', array('object' => $this));
        //Hook::exec('actionObject'.get_class($this).'DeleteAfter', array('object' => $this));

        $remove_children = $this->removeChildren();

        return $result && $remove_children;
    }    

    public function removeChildren()
    {        
        $db_instance = Db::getInstance();      

        $children =  $this->getChildren();

        $result = false;

        if (!$children)
            return true;
        else {
            foreach ($children as $key => $child) {
                $object = new ListingItem($child['id_item']);
                $result = $object->delete();

                if (!$result)
                    return $result;                
            }

            return $result;
        }        
    }

    public function getChildren()
    {
        $id_listing = $this->id_listing;

        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('skeleton_listing_item', 'sli');        
        $sql->where('id_parent = ' . $id_listing);        

        return Db::getInstance()->executeS($sql); 
    }

    public static function getListingsWithChildren()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('skeleton_listing', 'sl');
        $sql->leftJoin('skeleton_listing_lang', 'sll', 'sll.`id_listing` = sl.`id_listing`');
        $sql->leftJoin('skeleton_listing_item', 'sli', 'sli.`id_parent` = sl.`id_listing`');
        $sql->leftJoin('skeleton_listing_item_lang', 'slil', 'sli.`id_item` = slil.`id_item`');
        $sql->where('1');

        $result = Db::getInstance()->executeS($sql);        

        if ($result)
            $result = self::transformData($result);        

        return $result;
    }

    public static function transformData(array $data)
    {
        if (!$data)
            return $data;
        
        $return = array();

        foreach ($data as $key => $datum) {
            $return[$datum['id_listing']]['title_listing'] = $datum['title_listing'];
            $return[$datum['id_listing']]['listing_items'][] = $datum['item_title'];
        }

        return $return;
    }
}
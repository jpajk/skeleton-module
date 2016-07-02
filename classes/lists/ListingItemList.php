<?php

namespace skeletonmodule\classes\lists;

if (!defined('_PS_VERSION_'))
	exit;

use Db;
use DbQuery;
use HelperList;
use Tools;

class ListingItemList
{
	private $module;

	function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;
	}

	public function getList()
	{
		$db_result = $this->getQuery();

		$fields_list = array(
				'id_listing' => array(
					'title' => $this->l('ID'),
					'search' => false,
				),
				'title_listing' => array(
					'item_title' => $this->l('Title'),
					'search' => false,
				),
				'item_link' => array(
					'title' => $this->l('Link'),
					'search' => false,
				),
			);	

		$helper = new HelperList();        
        $helper->simple_header = false;
        $helper->identifier = 'id_listing';        
        $helper->actions = array('delete');
        $helper->show_toolbar = true;
        $helper->title = $this->module->displayName;        
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = 'index.php?controller=AdminModules&configure=skeleton_module&tab_module=others&module_name=skeleton_module';
        
        return $helper->generateList($db_result, $this->fields_list);
	}

	public function getQuery()
	{
		$sql = new DbQuery();
        $sql->select('*');
        $sql->from('skeleton_listing', 'sl');        
        $sql->where('1');

        return Db::getInstance()->executeS($sql); 
	}
}
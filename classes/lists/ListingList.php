<?php

namespace skeletonmodule\classes\lists;

if (!defined('_PS_VERSION_'))
	exit;

use Context;
use Db;
use DbQuery;
use Tools;

use skeletonmodule\SkeletonModuleBase;
use skeletonmodule\classes\helpers\HelperListModified;

class ListingList
{
	private $module;
	private $context;

	function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;
		$this->context = Context::getContext();
	}

	public function getList()
	{
		$db_result = $this->getQuery();

		$fields_list = array(
				'id_listing' => array(
					'title' => $this->module->translations['id'],
					'search' => false,
				),
				'title_listing' => array(
					'item_title' => $this->module->translations['title'],
					'search' => false,
				),				
			);	

		$helper = new HelperListModified();        
        $helper->simple_header = false;
        $helper->identifier = 'id_listing';        
        $helper->actions = array('view', 'edit', 'delete');
        $helper->show_toolbar = true;
        $helper->shopLinkType = false;        
        $helper->title = $this->module->translations['title_listing'];
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->mod_path = 'listing';
        $helper->currentIndex = 'index.php?controller=AdminModules&configure='.$this->module->name.'&tab_module=others&module_name=skeleton_module';
        $helper->toolbar_btn['new'] = array(
			'href' => $this->context->link->getAdminLink('AdminModules', false)
					  .'&configure='
					  .$this->module->name
					  .'&tab_module='
					  .$this->module->tab
					  .'&module_name='
					  .$this->module->name
					  .'&mod_path=edit_listing'
					  .'&token='
					  .Tools::getAdminTokenLite('AdminModules'),
			'desc' => $this->module->translations['add_new_list']
		);

        return $helper->generateList($db_result, $fields_list);
        
	}

	public function getQuery()
	{
		$context = Context::getContext();

		$sql = new DbQuery();
        $sql->select('*');
        $sql->from('skeleton_listing_lang', 'sll');        
        $sql->where('1');
        $sql->where('id_lang =' . (int) $context->language->id);

        return Db::getInstance()->executeS($sql); 
	}	
}
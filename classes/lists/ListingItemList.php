<?php

namespace skeletonmodule\classes\lists;

if (!defined('_PS_VERSION_'))
	exit;

use Context;
use Db;
use DbQuery;
use HelperList;
use Tools;

use skeletonmodule\SkeletonModuleBase;
use skeletonmodule\classes\helpers\HelperListModified;

class ListingItemList
{
	private $module;
	private $context;
	private $id_listing;


	function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;
		$this->context = Context::getContext();
		$this->id_listing = Tools::getValue('id_listing');
	}

	public function getList()
	{
		$db_result = $this->getQuery();
		$id_listing = (int) Tools::getValue('id_listing');

		$fields_list = array(
				'id_item' => array(
					'title' => $this->module->translations['id'],
					'search' => false,
				),
				'item_title' => array(
					'item_title' => $this->module->translations['title'],
					'search' => false,
				),
				'item_link' => array(
					'title' => $this->module->translations['link'],
					'search' => false,
				),
			);	

		$helper = new HelperListModified();        
        $helper->simple_header = false;
        $helper->identifier = 'id_item';        
        $helper->actions = array('edit', 'delete');
        $helper->show_toolbar = true;
        $helper->shopLinkType = false;        
        $helper->title = $this->module->translations['title_listing'];
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->mod_path = 'listing_item';
        $helper->currentIndex = 'index.php?controller=AdminModules&configure='.$this->module->name.'&tab_module=others&module_name=skeleton_module';
        $helper->toolbar_btn['new'] = array(
			'href' => $this->context->link->getAdminLink('AdminModules', false)
					  .'&configure='
					  .$this->module->name
					  .'&tab_module='
					  .$this->module->tab
					  .'&module_name='
					  .$this->module->name
					  .'&mod_path=edit_listing_item'
					  .'&id_listing='.$id_listing
					  .'&token='
					  .Tools::getAdminTokenLite('AdminModules'),
			'desc' => $this->module->translations['add_new_list']
		);

		$helper->url_options = array(
				'id_listing' => $this->id_listing
			);

        return $helper->generateList($db_result, $fields_list);
	}

	public function getQuery()
	{
		$context = Context::getContext();

		$sql = new DbQuery();
        $sql->select('*');
        $sql->from('skeleton_listing_item_lang', 'sli');        
        $sql->where('1');
        $sql->where('id_lang =' . (int) $context->language->id);

        return Db::getInstance()->executeS($sql); 
	}
}
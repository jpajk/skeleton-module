<?php

namespace skeletonmodule\classes\forms;

if (!defined('_PS_VERSION_'))
	exit;

use Configuration;
use Context;
use HelperForm;
use Language;
use Link;
use Tools;

use skeletonmodule\classes\listing\ListingItem;
use skeletonmodule\SkeletonModuleBase;

class ListingItemForm
{
	private $module;
	private $id_listing;
	private $context;

	public function __construct(SkeletonModuleBase $module, $id_listing_item=null)
	{
		$this->module = $module;
		$this->id_listing = Tools::getValue('id_listing');
		$this->id_listing_item = $id_listing_item;
		$this->context = Context::getContext();
	}

	/**
	 * Consider pulling into traits
	 */
	public function getForm()
	{
		$fields_form = array(
				array(
						'form' => array(							
							'input' => array(
								array(
										'type' => 'text',
										'label' =>  $this->module->translations['title'],
										'name' => 'item_title',
										'required' => true
								),								
								array(
										'type' => 'text',
										'label' =>  $this->module->translations['link'],
										'name' => 'item_link',
										'required' => true
								),
								array(
										'type' => 'hidden',
										'name' => 'mod_path',
								),								
								array(
										'type' => 'hidden',
										'name' => 'id_listing_item',
								),
								array(
										'type' => 'hidden',
										'name' => 'id_listing',
								),
							),
							'submit' => array(
									'title' =>  $this->module->translations['save'],
							),	

						),						
					)				
			);		

		$link = new Link();
		$helper = new HelperForm();
		$helper->show_toolbar = false;		
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;		
		$this->fields_form = array();
		$helper->id = (int)Tools::getValue('id_carrier');		
		$helper->submit_action = 'btnSubmit';
		$helper->currentIndex = $link->getAdminLink('AdminModules', false).'&configure='.$this->module->name.'&tab_module='.$this->module->tab.'&module_name='.$this->module->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->fields_value = $this->getFieldsValue();

		return $helper->generateForm($fields_form);

	}

	public function getFieldsValue()
	{
		$fields_value = array(
				'mod_path' 			=> 'submit_listing_item',
				'id_listing'		=> $this->id_listing,
				'id_listing_item'	=> $this->id_listing_item,
			);

		if ($this->id_listing_item) {
			$object = new ListingItem($this->id_listing);
			$context = Context::getContext();
			$id_lang = $context->language->id;
			$fields_value['id_listing_item'] = $object->title_listing[$id_lang];			
		}

		return $fields_value; 
	}
}
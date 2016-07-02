<?php

namespace skeletonmodule\classes\forms;

if (!defined('_PS_VERSION_'))
	exit;

use Configuration;
use HelperForm;
use Language;
use Link;
use Tools;

use skeletonmodule\SkeletonModuleBase;

class ListingForm
{
	private $module;
	private $id_listing;

	public function __construct(SkeletonModuleBase $module, $id_listing=null)
	{
		$this->module = $module;
		$this->id_listing = $id_listing;
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
										'name' => 'skeleton_listing_title',
										'required' => true
								),
								array(
										'type' => 'hidden',
										'name' => 'mod_path',
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
		return array(
				'mod_path' 		=> 'submit_listing',
				'id_listing'	=> (string) $this->id_listing
			);
	}
}
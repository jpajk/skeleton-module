<?php

namespace skeletonmodule\classes\forms;

if (!defined('_PS_VERSION_'))
	exit;

use HelperForm;

class ListingItemForm
{
	private $module;

	public function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;
	}

	/**
	 * Consider pulling into traits
	 */
	public function getForm()
	{
		$fields_form = array(
				'form' => array(
						'legend' => array(
							'title' => $this->l('Contact details'),
							'icon' => 'icon-envelope'
						)
					),
				'input' => array(
						array(
								'type' => 'text',
								'label' => $this->l('Title'),
								'name' => 'skeleton_listing_title',
								'required' => true
						),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			);

		$helper = new HelperForm();
		$helper->show_toolbar = false;		
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;		
		$this->fields_form = array();
		$helper->id = (int)Tools::getValue('id_carrier');		
		$helper->submit_action = 'btnSubmit';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form));

	}

	public function getFieldsValue()
	{
		
	}
}
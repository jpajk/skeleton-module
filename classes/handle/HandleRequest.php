<?php

namespace skeletonmodule\classes\handle;

if (!defined('_PS_VERSION_'))
	exit;

use Context;
use Controller;
use Tools;
use Validate;

use skeletonmodule\SkeletonModuleBase;
use skeletonmodule\classes\forms\ListingForm;
use skeletonmodule\classes\lists\ListingList;

use skeletonmodule\classes\listing\Listing;

class HandleRequest
{
	private $module;

	public function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;
	}

	public function handle()
	{
		$mod_path = (string) Tools::getValue('mod_path');
		$path = $mod_path ? $mod_path : "default";		

		return $this->handleByName($path);
	}

	public function handleByName($path="default")
	{
		$paths = $this->getHandlers();
		$handle = $paths[$path];
		return $handle();
	}

	public function getHandlers()
	{
		return array(
				/** Edit listing */
				"edit_listing" => function() {
					$id_listing = (int) Tools::getValue('id_listing');
					$listing_form = new ListingForm($this->module, $id_listing);
					$output = $listing_form->getForm();					
					$this->module->setOutputContainer($output);
				},
				/** Submit listing */
				"submit_listing" => function() {
					$id_listing = Tools::getValue('id_listing');
					$id_listing = $id_listing ? $id_listing : null;
					$title = Tools::getValue('skeleton_listing_title');
					$title_validate = Validate::isGenericName($title);;

					if ($title_validate) {
						$listing = new Listing($id_listing);
						$listing->title_listing = $title;
						$result = $listing->save();						
					} else {
						$controller = Context::getContext()->controller;
						$controller->errors[] = $this->module->translations['unable_to_add_listing'];
					}

					$this->handleByName();
				},
				"delete_listing" => function() {
					$id_listing = (int) Tools::getValue('id_listing');					

					if (!$id_listing)
						$this->handleByName();

					$context = Context::getContext();
					$object = new Listing($id_listing, $context->language->id);
					$object->delete();
					$this->handleByName();
				},
				/** Default */
				"default" => function() {
					$listing_list = new ListingList($this->module);
					$output = $listing_list->getList();					
					$this->module->setOutputContainer($output);
				}
			);
	}	
}
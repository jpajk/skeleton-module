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
use skeletonmodule\classes\forms\ListingItemForm;
use skeletonmodule\classes\lists\ListingList;
use skeletonmodule\classes\lists\ListingItemList;
use skeletonmodule\classes\listing\Listing;
use skeletonmodule\classes\listing\ListingItem;

class HandleRequest
{
	private $module;
	private $options = array();

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
				/** View listing */
				"view_listing" => function() {
					$id_listing = (int) Tools::getValue('id_listing');
					$listing_item_form = new ListingItemList($this->module);
					$output = $listing_item_form->getList();					
					$this->module->setOutputContainer($output);
				},
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

				/** Add listing item */
				"edit_listing_item" => function() {
					$id_item = (int) Tools::getValue('id_item');
					$listing_form = new ListingItemForm($this->module, $id_item);
					$output = $listing_form->getForm();					
					$this->module->setOutputContainer($output);
				},
				/**
				 * @todo pass options
				 */
				"submit_listing_item" => function() {
					$id_listing_item = Tools::getValue('id_listing_item');
					$id_listing_item = $id_listing_item ? $id_listing_item : null;
					
					$title = Tools::getValue('item_title');
					$link = Tools::getValue('item_link');
					$id_parent = (int) Tools::getValue('id_listing');

					$title_validate = (bool) Validate::isGenericName($title);
					$link_validate = (bool) Validate::isUrl($link);

					if ($title_validate && $link_validate && (bool) $id_parent) {
						$listing_item = new ListingItem($id_listing_item);
						
						$listing_item->item_title = $title;
						$listing_item->item_link = $link;
						$listing_item->id_parent = $id_parent;

						$listing_item = $listing_item->save();						
					} else {
						$controller = Context::getContext()->controller;
						$controller->errors[] = $this->module->translations['unable_to_add_listing'];
					}

					$this->handleByName("view_listing");
				},
				"delete_listing_item" => function() {
					$id_item = (int) Tools::getValue('id_item');					

					if (!$id_item)
						$this->handleByName("view_listing");

					$context = Context::getContext();
					$object = new ListingItem($id_item, $context->language->id);
					$object->delete();
					$this->handleByName("view_listing");
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
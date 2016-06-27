<?php

namespace skeletonmodule\classes;

if (!defined('_PS_VERSION_'))
    exit;

use skeletonmodule\SkeletonModuleBase;

class Translations
{
	private $module;

	public function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;	
	}

	public function getTranslations()
	{
		return array(
				'module_name'  		 => $this->module->l('Skeleton Module'),
				'module_description' => $this->module->l('Module description'),
				'are_you_sure' 		 => $this->module->l('Are you sure?')
			);
	}


}
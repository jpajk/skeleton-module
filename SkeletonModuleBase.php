<?php

namespace skeletonmodule;

if (!defined('_PS_VERSION_'))
	exit;

use Module;
use Tools;

use skeletonmodule\classes\install\InstallModule;
use skeletonmodule\classes\uninstall\UninstallModule;
use skeletonmodule\classes\Translations;

class SkeletonModuleBase extends Module
{	
    private $output_container = '';

	public function __construct()
    {
        $this->name = 'skeletonmodule';
        $this->tab = 'others'; 
        $this->version = '1.0.0'; 
        $this->author = 'Somatek';
        $this->need_instance = 0; 
        $this->ps_versions_compliancy = array( 
        		'min' => '1.6.1', 
        		'max' => _PS_VERSION_ 
        	); 
        $this->bootstrap = true;

        parent::__construct();

        $translations = new Translations($this);
        $this->translations = $translations->getTranslations();

        $this->displayName = $this->translations['module_name']; 
        $this->description = $this->translations['module_description']; 
        $this->confirmUninstall = $this->translations['are_you_sure']; ;       
    }

    /**
     * Called on module installation
     * @return bool
     */
    public function install()
    {
        $install_module = new InstallModule($this);
        $installation = $install_module->performInstallation();

        if (!parent::install() || !$installation)
        {
            return false;
        }

        return true;

    }

    /**
     * Called on module uninstallation
     * @return bool
     */
    public function uninstall() 
    {
        $uninstall_module = new UninstallModule($this);
        $installation = $uninstall_module->performUninstallation();

        if (!parent::uninstall() || !$uninstall_module) 
        {
            return false;
        }
 
        return true;    
    }

	public function getContent()
	{
		return null;
	}

    protected function setOutputContainer($content)
    {
        $this->output_container = $content;

        return $this;
    }

    protected function getOutputContainer()
    {
        return $this->output_container;
    }

}
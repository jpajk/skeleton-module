<?php

namespace skeletonmodule;

if (!defined('_PS_VERSION_'))
	exit;

use Module;
use Tools;

use skeletonmodule\classes\handle\HandleRequest;
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
        
        $this->translations = $this->getTranslations();

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
        $handle_request = new HandleRequest($this);
        $handle_request->handle();

		return $this->getOutputContainer();
	}

    public function setOutputContainer($content)
    {
        $this->output_container .= $content;

        return $this;
    }

    public function getOutputContainer()
    {
        return $this->output_container;
    }

    public function getTranslations()
    {
        return array(
                /** Module translations */
                'module_name'            => $this->l('Skeleton Module'),
                'module_description'     => $this->l('Module description'),
                'are_you_sure'           => $this->l('Are you sure?'),

                /** List translations */
                'id'                     => $this->l('ID'),
                'title'                  => $this->l('Title'),
                'title_listing'          => $this->l('Listing titles'),
                'add_new_list'           => $this->l('Add new list'),

                /** Form translations */
                'contact_details'        => $this->l('Contact details'),
                'save'                   => $this->l('Save'),
                'skeleton_listing_title' => $this->l('Skeleton listing title'),

                /** Error messages */
                'unable_to_add_listing'  => $this->l('Wrong listing name.'),
            );
    }

}
<?php

if (!defined('_PS_VERSION_'))
	exit;

use \Module;

class SkeletonModuleBase extends Module
{	
	public function __construct()
    {
        $this->name = 'skeletonmodule';
        $this->tab = 'others'; 
        $this->version = '1.0.0'; 
        $this->author = '';
        $this->need_instance = 0; 
        $this->ps_versions_compliancy = array( 'min' => '1.6.1', 'max' => _PS_VERSION_ ); 
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Skeleton Module'); 
        $this->description = $this->l('Module description.');         
        $this->confirmUninstall = $this->l('Are you sure?');       
    }

    public function install()
    {
        if (!parent::install())
        {
            return false;
        }

        return true;

    }

    public function uninstall() 
    {
        if (!parent::uninstall()) 
        {
            return false;
        }
 
        return true;    
    }

}
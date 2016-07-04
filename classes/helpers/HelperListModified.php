<?php

namespace skeletonmodule\classes\helpers;

if (!defined('_PS_VERSION_'))
	exit;

use Tools;
use HelperList;

class HelperListModified extends HelperList
{
	/**
     * Display edit action link
     */
    public function displayEditLink($token = null, $id, $name = null)
    {
        $tpl = $this->createTemplate('list_action_edit.tpl');
        if (!array_key_exists('Edit', self::$cache_lang)) {
            self::$cache_lang['Edit'] = $this->l('Edit', 'Helper');
        }                

        $tpl->assign(array(
            'href' => $this->currentIndex.'&'.$this->identifier.'='.$id
            		  .'&mod_path='.(isset($this->mod_path) ? 'edit_' . $this->mod_path : '')
            		  .'&update'.$this->table.($this->page && $this->page > 1 ? '&page='.(int)$this->page : '')
                      .$this->getUrlOptions()
            		  .'&token='.($token != null ? $token : $this->token),
            'action' => self::$cache_lang['Edit'],
            'id' => $id
        ));

        return $tpl->fetch();
    }

	public function displayDeleteLink($token = null, $id, $name = null)
    {
        $tpl = $this->createTemplate('list_action_delete.tpl');

        if (!array_key_exists('Delete', self::$cache_lang)) {
            self::$cache_lang['Delete'] = $this->l('Delete', 'Helper');
        }

        if (!array_key_exists('DeleteItem', self::$cache_lang)) {
            self::$cache_lang['DeleteItem'] = $this->l('Delete selected item?', 'Helper', true, false);
        }

        if (!array_key_exists('Name', self::$cache_lang)) {
            self::$cache_lang['Name'] = $this->l('Name:', 'Helper', true, false);
        }

        if (!is_null($name)) {
            $name = addcslashes('\n\n'.self::$cache_lang['Name'].' '.$name, '\'');
        }

        $data = array(
            $this->identifier => $id,
            'href' => $this->currentIndex
            		  .'&'.$this->identifier.'='.$id
            		  .'&mod_path='.(isset($this->mod_path) ? 'delete_' . $this->mod_path : '')
            		  //.'&delete'.$this->table
                      .$this->getUrlOptions()
            		  .'&token='.($token != null ? $token : $this->token),
            'action' => self::$cache_lang['Delete'],
        );

        if ($this->specificConfirmDelete !== false) {
            $data['confirm'] = !is_null($this->specificConfirmDelete) ? '\r'.$this->specificConfirmDelete : Tools::safeOutput(self::$cache_lang['DeleteItem'].$name);
        }

        $tpl->assign(array_merge($this->tpl_delete_link_vars, $data));

        return $tpl->fetch();
    }

    /**
     * Display view action link
     */
    public function displayViewLink($token = null, $id, $name = null)
    {
        $tpl = $this->createTemplate('list_action_view.tpl');
        if (!array_key_exists('View', self::$cache_lang)) {
            self::$cache_lang['View'] = $this->l('View', 'Helper');
        }

        $tpl->assign(array(
            'href' => $this->currentIndex.'&'.$this->identifier.'='.$id
                      .'&view'.$this->table
                      .'&mod_path='.(isset($this->mod_path) ? 'view_' . $this->mod_path : '')
                      .$this->getUrlOptions()
                      .'&token='.($token != null ? $token : $this->token),
            'action' => self::$cache_lang['View'],
        ));

        return $tpl->fetch();
    }

    public function getUrlOptions()
    {
        $url_options = '';

        if (isset($this->url_options) && !empty($this->url_options)) {
            foreach ($this->url_options as $key => $option) {
                $url_options .= '&'.$key.'='.$option;
            }
        }

        return $url_options;
    }

}
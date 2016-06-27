<?php

namespace skeletonmodule\classes\uninstall;

use skeletonmodule\SkeletonModuleBase;
use skeletonmodule\classes\uninstall\UninstallActions;

if (!defined('_PS_VERSION_'))
	exit;

class UninstallModule 
{
	private $successful = true;
	private $install_actions = array();
	private $module;

	public function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;
	}

	/**
	 * Iterates over InstallActions 
	 * @return boolean
	 */
	public function performUninstallation()
	{
		$actions = new UninstallActions();
		$methods = get_class_methods($actions);

		foreach ($methods as $index => $method) {
			$result = $actions->{$method}();

			if ($result === false) {
				$this->setSuccessful(false);

				break;
			}
		}

		return $this->getSuccessful();
	}

	public function getSuccessful()
	{
		return $this->successful;
	}

	/**	 
	 * @param bool $value
	 * @return skeletonmodule\classes\uninstall\UninstallModule;
	 */
	public function setSuccessful($value)
	{
		$this->successful = (bool) $value;

		return $this;
	}
}
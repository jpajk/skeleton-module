<?php

namespace skeletonmodule\classes\install;

use skeletonmodule\SkeletonModuleBase;
use skeletonmodule\classes\install\InstallActions;

if (!defined('_PS_VERSION_'))
	exit;

class InstallModule 
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
	public function performInstallation()
	{
		$actions = new InstallActions();
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

	public function setSuccessful($value)
	{
		$this->success = $value;

		return $this;
	}
}
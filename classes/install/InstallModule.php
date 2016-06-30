<?php

namespace skeletonmodule\classes\install;

use Db;

use skeletonmodule\classes\Queries;


if (!defined('_PS_VERSION_'))
	exit;

class InstallModule
{
	private $module;

	public function __construct(SkeletonModuleBase $module)
	{
		$this->module = $module;
	}
	/**
	 * Iterates over installation actions
	 * @return boolean
	 */
	public function performInstallation()
	{
		$actions = $this->getInstallActions();

		foreach ($actions as $index => $action) {
			$result = $action();

			if (!$result)
				break;
			
		}

		return $result;
	}

	protected function getInstallActions()
	{
		return array(
				/**
				 * Execute database queries
				 * @return boolean
				 */
				"executeQueries" => function() {
					$queries_up = Queries::getQueriesUp();
					$db = Db::getInstance();		

					foreach ($queries_up as $index => $query) {
						$result = $db->execute($query);

						if (!$result)
							break;
			
					}

					return $result;
				},
				/**
				 * Register hooks for the module
				 * @return boolean
				 */
				"registerHooks" => function() {
					return true;
				}
			);
	}

}
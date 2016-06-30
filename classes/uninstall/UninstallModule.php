<?php

namespace skeletonmodule\classes\uninstall;

use Db;

use skeletonmodule\classes\Queries;

if (!defined('_PS_VERSION_'))
	exit;

class UninstallModule
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
	public function performUninstallation()
	{
		$actions = $this->getUninstallActions();

		foreach ($actions as $index => $action) {
			$result = $action();

			if (!$result)
				break;
			
		}

		return $result;
	}

	protected function getUninstallActions()
	{
		return array(
				/**
				 * Execute database queries
				 * @return boolean
				 */
				"executeQueries" => function() {
					$queries_up = Queries::getQueriesDown();
					$db = Db::getInstance();		

					foreach ($queries_up as $index => $query) {
						$result = $db->execute($query);

						if (!$result)
							break;
			
					}

					return $result;
				},				
			);
	}

}
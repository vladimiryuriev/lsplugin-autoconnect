<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*
*	Plugin Autoconnect
*	Vladimir Yuriev (extravert)
*	contact e-mail: support@lsmods.ru
*
*/

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginAutoconnect extends Plugin {
	/**
	 * Plugin Autoconnect activation
	 */
	public function Activate() {
		//$this->ExportSQL(dirname(__FILE__).'/tasks.sql');
		return true;
	}
	/**
	 * Init plugin Autoconnect
	 */
	public function Init() {
	}
}
?>
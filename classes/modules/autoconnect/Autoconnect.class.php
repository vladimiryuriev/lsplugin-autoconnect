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

set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__));
require_once('mapper/Autoconnect.mapper.class.php');

/**
 * Plugin Autoconnect
 *
 */
class PluginAutoconnect_ModuleAutoconnect extends Module {
	
	
	protected $oMapper;

	/**
	 * Инициализация модуля
	 */
	public function Init() {
		$this->oMapper=new PluginAutoconnect_ModuleAutoconnect_MapperAutoconnect($this->Database_GetConnect());
		$this->oUserCurrent=$this->User_GetUserCurrent();
	}

	/**
	 * Get Blogs
	 *
	 */
	public function GetBlogs() {
		$blogs=$this->oMapper->GetAvailableBlogs($this->oUserCurrent);
		$blogs=$this->Blog_GetBlogsAdditionalData($blogs);
		return $blogs;
	}

}
?>
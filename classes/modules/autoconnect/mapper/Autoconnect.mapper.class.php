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

class PluginAutoconnect_ModuleAutoconnect_MapperAutoconnect extends Mapper {	
	
	public function GetAvailableBlogs($oUserCurrent) {
		
		/*
		 * Допустимые роли в закрытых блогах
		 */
		 
		$aBlogRoles=array(
			ModuleBlog::BLOG_USER_ROLE_USER,
			ModuleBlog::BLOG_USER_ROLE_MODERATOR,
			ModuleBlog::BLOG_USER_ROLE_ADMINISTRATOR
		);
		
		$sql = "SELECT
					b.blog_id
					FROM
						".Config::Get('db.table.blog')." as b
					WHERE
						(b.user_owner_id = ? AND b.blog_type <> 'personal')
						OR
							(b.blog_type = 'open' 
							AND 
							b.user_owner_id <> ?
							AND 
							b.blog_limit_rating_topic <= ?
							)
						OR
							(b.blog_type = 'close' 
							AND 
							b.blog_id IN (SELECT bu.blog_id FROM ".Config::Get('db.table.blog_user')." AS bu WHERE bu.user_id = ? AND bu.user_role IN (?a))
							AND 
							b.blog_limit_rating_topic <= ?
							)
					";
        $aBlogs=array();
        if ($aRows=$this->oDb->select($sql,$oUserCurrent->getId(),$oUserCurrent->getId(),$oUserCurrent->getRating(),$oUserCurrent->getId(),$aBlogRoles,$oUserCurrent->getRating())) { 
			foreach ($aRows as $aBlog) {
				$aBlogs[]=$aBlog['blog_id'];
			}
        }
        return $aBlogs;
	}

}
?>
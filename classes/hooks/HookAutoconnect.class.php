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
class PluginAutoconnect_HookAutoconnect extends Hook {
       
		public function RegisterHook() {
			$this->AddDelegateHook('module_blog_getblogsallowbyuser_before','blogAllow',__CLASS__);
			$this->AddDelegateHook('module_acl_isallowblog_before','blogConnect',__CLASS__);
        }
		
		
		/**
		 * Поменяем метод Blog_GetBlogsAllowByUser
		 *
		 */
		public function blogAllow($aVars) {
		
			$oUser=$aVars[0];
			
			if ($oUser->isAdministrator()) {
				return $this->Blog_GetBlogs();
			} else {						
				return $this->PluginAutoconnect_Autoconnect_GetBlogs();
			}
			
		}
		
		public function blogConnect($aVars) {
			
			$oBlog=$aVars[0];
			$oUser=$aVars[1];
			
			if ($oUser->isAdministrator()) {
				return true;
			}
			if ($oBlog->getOwnerId()==$oUser->getId()) {
				return true;
			}
			if ($oBlogUser=$this->Blog_GetBlogUserByBlogIdAndUserId($oBlog->getId(),$oUser->getId())) {
				if ($this->ACL_CanAddTopic($oUser,$oBlog) or $oBlogUser->getIsAdministrator() or $oBlogUser->getIsModerator()) {
					return true;
				}
			} else {
				if ($oBlog->getType()=='open' && $this->ACL_CanAddTopic($oUser,$oBlog)) {
					$oBlogUserNew=Engine::GetEntity('Blog_BlogUser');
					$oBlogUserNew->setBlogId($oBlog->getId());
					$oBlogUserNew->setUserId($oUser->getId());
					$oBlogUserNew->setUserRole(ModuleBlog::BLOG_USER_ROLE_USER);
					$this->Blog_AddRelationBlogUser($oBlogUserNew);
					/**
					 * Увеличиваем число читателей блога
					 */
					$oBlog->setCountUser($oBlog->getCountUser()+1);
					$this->Blog_UpdateBlog($oBlog);
					
					return true;
				}
			}
			return false;
		}
		
}

<?php
namespace GDO\Links\Method;

use GDO\Core\Method;
use GDO\Links\GDO_Link;
use GDO\User\GDO_User;
use GDO\Util\Common;
use GDO\UI\GDT_Redirect;

/**
 * Increase visit counter and redirect.
 * 
 * @author gizmore
 */
final class Visit extends Method
{
	public function execute()
	{
	    $link = GDO_Link::table()->find(Common::getRequestString('id'));
		$user = GDO_User::current();
		$level = $link->getLevel();
		if ($level > $user->getLevel())
		{
			return $this->error('err_link_level', [$level])->addField(GDT_Redirect::hrefBack());
		}
		
		$link->increase('link_views');
		
		return $this->redirect($link->getURL());
	}
}

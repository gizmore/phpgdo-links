<?php
namespace GDO\Links\Method;

use GDO\Core\Method;
use GDO\Links\GDO_Link;
use GDO\User\GDO_User;
use GDO\UI\GDT_Redirect;
use GDO\Core\GDT_Object;

/**
 * Increase visit counter and redirect.
 * 
 * @author gizmore
 */
final class Visit extends Method
{
	public function gdoParameters(): array
	{
		return [
			GDT_Object::make('id')->table(GDO_Link::table())->notNull(),
		];
	}
	
	public function getLink(): GDO_Link
	{
		return $this->gdoParameterValue('id');
	}
	
	public function execute()
	{
	    $link = $this->getLink();
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

<?php
namespace GDO\Links\Method;

use GDO\Links\Module_Links;
use GDO\UI\MethodPage;

final class Overview extends MethodPage
{

	public function onRenderTabs(): void
	{
		Module_Links::instance()->renderTabs();
	}

}

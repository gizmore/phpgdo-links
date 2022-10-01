<?php
namespace GDO\Links;

use GDO\Net\GDT_Url;
use GDO\Core\GDT;
use GDO\Core\GDT_Template;
use GDO\Core\WithGDO;

final class GDT_LinkUrl extends GDT_Url
{
	use WithGDO;
	
	protected function __construct()
	{
	    parent::__construct();
		$this->reachable = true;
		$this->allowLocal = true;
		$this->notNull();
		$this->unique();
	}
	
	public function renderHTML() : string
	{
		if (isset($this->gdo))
		{
			return GDT_Template::php('Links', 'cell_link_url.php', [
				'field' => $this,
				'link' => $this->gdo,
			]);
		}
		return GDT::EMPTY_STRING;
	}

}

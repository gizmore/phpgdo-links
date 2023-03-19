<?php
namespace GDO\Links;

use GDO\Core\GDT_Template;
use GDO\UI\GDT_Title;
use GDO\Core\WithGDO;

/**
 * Display the title of a link, or the censored message.
 * A link title has a minlength of 3. 
 * @author gizmore
 */
final class GDT_LinkTitle extends GDT_Title
{
	use WithGDO;
	
	public function isTestable() : bool { return false; }
	
	public function defaultLabel(): static { return $this->label('title'); }

	protected function __construct()
	{
	    parent::__construct();
		$this->min = 3;
		$this->max = 128;
		$this->notNull();
	}
	
	public function renderHTML() : string
	{
		return GDT_Template::php('Links', 'cell_link_title.php', ['link'=>$this->gdo, 'field'=>$this]);
	}

}

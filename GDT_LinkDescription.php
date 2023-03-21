<?php
namespace GDO\Links;

use GDO\Core\GDT_Template;
use GDO\Core\WithGDO;
use GDO\UI\GDT_Message;

/**
 * Display the title of a link, or the censored message.
 * A link title has a minlength of 3.
 *
 * @author gizmore
 */
final class GDT_LinkDescription extends GDT_Message
{

	use WithGDO;

	protected function __construct()
	{
		parent::__construct();
		$this->min = 3;
		$this->max = 512;
	}

	public function isTestable(): bool { return false; }

	public function defaultLabel(): self { return $this->label('description'); }

	public function renderHTML(): string
	{
		return GDT_Template::php('Links', 'cell_link_description.php', ['link' => $this->gdo, 'field' => $this]);
	}

}

<?php
namespace GDO\Links;

use GDO\Core\GDT_Template;
use GDO\Core\WithGDO;
use GDO\UI\GDT_Title;

/**
 * Display the title of a link, or the censored message.
 * A link title has a minlength of 3.
 *
 * @author gizmore
 */
final class GDT_LinkTitle extends GDT_Title
{

	use WithGDO;

	protected function __construct()
	{
		parent::__construct();
		$this->min = 3;
		$this->max = 128;
		$this->notNull();
	}

	public function isTestable(): bool { return false; }

	public function gdtDefaultLabel(): ?string
    { return 'title'; }

	public function renderHTML(): string
	{
		return GDT_Template::php('Links', 'cell_link_title.php', ['link' => $this->gdo, 'field' => $this]);
	}

}

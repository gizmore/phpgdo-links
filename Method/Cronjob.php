<?php
namespace GDO\Links\Method;

use GDO\Cronjob\MethodCronjob;

final class Cronjob extends MethodCronjob
{

	public function run(): void
	{
		$this->checkDeadLinks();
	}

	private function checkDeadLinks() {}

}

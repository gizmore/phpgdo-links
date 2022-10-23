<?php
namespace GDO\Links\tpl;
use GDO\Links\GDO_Link;
use GDO\User\GDO_User;
/** @var $link GDO_Link **/
$user = GDO_User::current();
$level = $link->getLevel();
if ($level > $user->getLevel())
{
	echo t('url_link_level', [$level]);
}
else
{
	echo $link->gdoDisplay('link_url');
}

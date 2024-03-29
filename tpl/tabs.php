<?php
namespace GDO\Links\tpl;

use GDO\Links\GDO_Link;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;

$tabs = GDT_Bar::make()->horizontal();
$numLinks = GDO_Link::getCounter();
$tabs->addField(GDT_Link::make('link_links')->textArgs($numLinks)->href(href('Links', 'Overview')));
$tabs->addField(GDT_Link::make('mt_links_add')->href(href('Links', 'Add')));
echo $tabs->render();

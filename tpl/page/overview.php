<?php
namespace GDO\Links\tpl\page;
use GDO\Links\GDO_Link;
use GDO\Table\GDT_List;
use GDO\Tags\GDT_TagCloud;
use GDO\User\GDO_User;

$user = GDO_User::current();

# Query
$gdo = GDO_Link::table();
$votes = $gdo->gdoVoteTable();
$query = $gdo->select('gdo_link.*, cb.user_name, vote_value as own_vote')->uncached()->
join("LEFT JOIN {$votes->gdoTableIdentifier()} v ON vote_object=link_id AND vote_user={$user->getID()}")->
join("LEFT JOIN gdo_user cb ON cb.user_id = gdo_link.link_created_by");

# Cloud
$cloud = GDT_TagCloud::make('cloud')->table($gdo);
$cloud->filterQuery($query, 'f');
echo $cloud->render();

# Table
$table = GDT_List::make('links')->listMode(GDT_List::MODE_LIST);
$table->gdo($gdo);
$table->href(href('Links', 'Overview'));
// $table->setupHeaders(true, true, true, false, false);
$table->addFields($gdo->getGDOColumns([
    'link_title', 'link_description',
    'link_views', 'link_votes', 'link_rating',
    'link_created_at', 'link_created_by',
]));
$table->query($query);
$table->countQuery($query->copy()->selectOnly('COUNT(*)'));
$table->paginateDefault();
$table->ordered(true, 'link_rating', false);
$table->searched();
$table->title('list_title_links_overview', [$table->countItems()]);
echo $table->render();

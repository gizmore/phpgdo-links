<?php
namespace GDO\Links\tpl\page;
use GDO\Links\GDO_Link;
use GDO\Table\GDT_List;
use GDO\Tags\GDT_TagCloud;
use GDO\User\GDO_User;
use GDO\Table\GDT_Filter;
use GDO\Table\GDT_Order;

$gdo = GDO_Link::table();
$user = GDO_User::current();

# Order field to be able to order the table.
$orderField = GDT_Order::make('o')->addFields(...$gdo->gdoColumnsCache());

# Filter field to be able to receive input and var/value the gdo way.
$filterField = GDT_Filter::make('f');

# Build query
$votes = $gdo->gdoVoteTable();
$query = $gdo->select('gdo_link.*, cb.user_name, vote_value as own_vote')->uncached()->
join("LEFT JOIN {$votes->gdoTableIdentifier()} v ON vote_object=link_id AND vote_user={$user->getID()}")->
join("LEFT JOIN gdo_user cb ON cb.user_id = gdo_link.link_created_by");

# Table
$table = GDT_List::make('links')->gdo($gdo);
$table->fetchAs($gdo);
$table->href(href('Links', 'Overview'));
$table->addHeaderFields(...$gdo->gdoColumnsOnly(
    'link_title', 'link_description',
    'link_views', 'link_votes', 'link_rating',
    'link_created_at', 'link_created_by',
));
$table->query($query);
$table->countQuery($query->copy()->selectOnly('COUNT(*)'));
$table->paginateDefault();
# Build whitelist
$table->ordered($orderField);
$table->searched();
$table->filtered(true, $filterField);
$table->title('list_title_links_overview', [$table->countItems()]);

# Cloud
$cloud = GDT_TagCloud::make('cloud')->table($gdo);
$cloud->filterQuery($query, $filterField);

# Out
echo $cloud->render();
echo $table->render();

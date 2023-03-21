<?php
namespace GDO\Links;

use GDO\Votes\GDO_VoteTable;

final class GDO_LinkVote extends GDO_VoteTable
{

	public function gdoVoteObjectTable() { return GDO_Link::table(); }

	public function gdoVoteMax() { return 5; }

	public function gdoVotesBeforeOutcome() { return Module_Links::instance()->cfgVotesBeforeOutcome(); }

	public function gdoVoteGuests() { return Module_Links::instance()->cfgGuestVotes(); }

	public function gdoVoteMin() { return 1; }

}

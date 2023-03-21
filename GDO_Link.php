<?php
namespace GDO\Links;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_DeletedAt;
use GDO\Core\GDT_Template;
use GDO\Core\GDT_UInt;
use GDO\Date\GDT_DateTime;
use GDO\DB\Cache;
use GDO\Language\GDT_Language;
use GDO\Tags\WithTags;
use GDO\User\GDO_User;
use GDO\User\GDT_Level;
use GDO\Votes\GDT_VoteCount;
use GDO\Votes\GDT_VoteRating;
use GDO\Votes\WithVotes;

final class GDO_Link extends GDO
{

	############
	### Tags ###
	############
	use WithTags;

	public static function getCounter()
	{
		if (null === ($count = Cache::get('gdo_link_count')))
		{
			$count = self::table()->countWhere();
			Cache::set('gdo_link_count', $count);
		}
		return $count;
	}

	#############
	### Votes ###
	#############
	use WithVotes;

	public static function recacheCounter()
	{
		Cache::remove('gdo_link_count');
	}

	public function gdoTagTable() { return GDO_LinkTag::table(); }

	###########
	### GDO ###
	###########

	public function gdoVoteTable() { return GDO_LinkVote::table(); }

	##############
	### Getter ###
	##############

	public function gdoVoteAllowed(GDO_User $user) { return $user->getLevel() >= $this->getLevel(); }

	public function getLevel() { return $this->gdoVar('link_level'); }

	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('link_id'),
			GDT_LinkUrl::make('link_url')->allowAll(),
			GDT_LinkTitle::make('link_title'),
			GDT_Language::make('link_lang')->emptyInitial(t('no_special_language')),
			GDT_LinkDescription::make('link_description'),
			GDT_Level::make('link_level')->notNull()->initial('0'),
			GDT_UInt::make('link_views')->notNull()->initial('0')->label('views'),
			GDT_VoteRating::make('link_rating'),
			GDT_VoteCount::make('link_votes'),
			GDT_DateTime::make('link_checked_at'),
			GDT_CreatedBy::make('link_created_by'),
			GDT_CreatedAt::make('link_created_at'),
			GDT_DeletedAt::make('link_deleted_at'),
		];
	}

	/**
	 * @return GDO_User
	 */
	public function getCreator() { return $this->gdoValue('link_created_by'); }

	public function getCreatorID() { return $this->gdoVar('link_created_by'); }

	public function getCreated() { return $this->gdoVar('link_created_at'); }

	public function getURL() { return $this->gdoVar('link_url'); }

	public function getTitle() { return $this->gdoVar('link_title'); }

	public function getViews() { return $this->gdoVar('link_views'); }

	public function canView(GDO_User $user = null)
	{
		$user = $user === null ? GDO_User::current() : $user;
		return $user->getLevel() >= $this->getLevel();
	}

	public function displayDescription() { return $this->getDescription(); }

	############
	### HREF ###
	############

	public function getDescription() { return $this->gdoVar('link_description'); }

	##############
	### Render ###
	##############

	public function href_visit() { return href('Links', 'Visit', '&id=' . $this->getID()); }

	###########
	### All ###
	###########

	public function getID(): ?string { return $this->gdoVar('link_id'); }

	public function renderList(): string { return GDT_Template::php('Links', 'listitem/link.php', ['link' => $this]); }

}

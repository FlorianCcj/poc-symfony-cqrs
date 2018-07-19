<?php
// MemberJoined.php
namespace App\MemberJoined\Domain;

class MemberJoined implements Event
{
	public $newMemberId;
	public $choosenPlanId;

	public function __construct(
		Uuid $newMemberId,
		Uuid $choosenPlanId
	)
	{
		$this->newMemberId = $newMemberId;
		$this->choosenPlanId = $choosenPlanId;
	}
}

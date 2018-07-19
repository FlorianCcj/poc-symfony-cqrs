<?php
// UpdateReferralProgramOnMemberJoined.php

class UpdateReferralProgramOnMemberJoined implements EventHandler
{
	function handle(MemberJoined $event): void
	{
		$findReferrerQuery = $this->connection->prepare("
			SELECT
				rt1.referral_id r1,
				rt2.referral_id r2
			FROM
				referral rt1
			LEFT JOIN
				referral rt2 
			ON 
				r1.referral_id = r2.id
			WHERE
				r1.id = :referrer
		");
	}

	public function listenTo(): string
	{
		return MemberJoined::class;
	}
}
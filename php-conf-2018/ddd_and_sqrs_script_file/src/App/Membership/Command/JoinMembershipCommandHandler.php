<?php
class JoinMembershipCommandHandler implements CommandHandler
{
	public function handle(Command $command): CommandResponse
	{
		return CommandResponse::withValue(
			$membership->id(),
			new MemberJoined($membership->id(), $plan->id())
		);
	}
}

/**
 * signature de withValue
 * static function withValue($value, Event... $events): CommandResponse {
 * return new CommandResponse($value, $events);
 * }
 */

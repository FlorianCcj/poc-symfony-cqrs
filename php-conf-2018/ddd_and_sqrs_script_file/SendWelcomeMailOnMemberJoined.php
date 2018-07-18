// SendWelcomeMailOnMemberJoined.php

class SendWelcomeMailOnMemberJoined implements EventHandler
{
	function __construct(
		Mailer $mailer,
		SubscriptionPlanRepository $planRepository,
		MemberRepository $memberRepository
	)
	{
		$this->mailer = $mailer;
		$this->planRepository = $planRepository;
		$this->memberRepository = $memberRepository;
	}

	/**
	 * envent handler is always void
	 */
	function handle(MemberJoined $event): void
	{
		$member = $this->memberRepository->get($event->memberId);
		$plan = $this->planRepository->get($event->choosePlanId);

		$message = "Hello .$member->firstname(), welcome in SportLand. We hope you'll enjoy your $plan->name() subscription";

		$mailer->send($member->email(), $message);
	}

	function listenTo(): string
	{
		return MemberJoined::class;
	}
}